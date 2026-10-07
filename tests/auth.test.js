import test from 'node:test';
import assert from 'node:assert/strict';
import request from 'supertest';
import { createApp } from '../src/app.js';
import { FakeUserRepository } from './helpers/fakeUserRepository.js';

function buildTestApp() {
  const userRepository = new FakeUserRepository();
  const app = createApp({
    userRepository,
    sessionSecret: 'test-session-secret-that-is-long-enough',
    isProduction: false,
  });
  return { app, userRepository };
}

const registration = {
  login: 'natalia',
  email: 'natalia@example.com',
  password: 'MyPassword123',
};

test('registration stores derived password data instead of plaintext', async () => {
  const { app, userRepository } = buildTestApp();

  const response = await request(app).post('/auth/register').send(registration);

  assert.equal(response.status, 201);
  assert.deepEqual(response.body.user, {
    id: 1,
    login: 'natalia',
    email: 'natalia@example.com',
  });

  const stored = await userRepository.findByLogin('natalia');
  assert.ok(Buffer.isBuffer(stored.passwordHash));
  assert.ok(Buffer.isBuffer(stored.passwordSalt));
  assert.equal(typeof stored.passwordIterations, 'number');
  assert.equal('password' in stored, false);
  assert.notEqual(stored.passwordHash.toString('utf8'), registration.password);
});

test('duplicate login or email returns 409', async () => {
  const { app } = buildTestApp();

  assert.equal(
    (await request(app).post('/auth/register').send(registration)).status,
    201,
  );

  const duplicate = await request(app).post('/auth/register').send({
    login: 'natalia',
    email: 'other@example.com',
    password: 'AnotherPassword123',
  });

  assert.equal(duplicate.status, 409);
});

test('unknown login and wrong password return the same public error', async () => {
  const { app } = buildTestApp();
  await request(app).post('/auth/register').send(registration);

  const unknown = await request(app).post('/auth/login').send({
    login: 'nobody',
    password: 'whatever',
  });

  const wrongPassword = await request(app).post('/auth/login').send({
    login: 'natalia',
    password: 'wrong-password',
  });

  assert.equal(unknown.status, 401);
  assert.equal(wrongPassword.status, 401);
  assert.deepEqual(unknown.body, { error: 'Invalid login or password' });
  assert.deepEqual(wrongPassword.body, unknown.body);
});

test('successful login establishes a session that can access profile', async () => {
  const { app } = buildTestApp();
  const agent = request.agent(app);

  await agent.post('/auth/register').send(registration).expect(201);
  await agent
    .post('/auth/login')
    .send({ login: 'natalia', password: 'MyPassword123' })
    .expect(200);

  const profile = await agent.get('/profile');

  assert.equal(profile.status, 200);
  assert.deepEqual(profile.body.user, {
    id: 1,
    login: 'natalia',
    email: 'natalia@example.com',
  });
});

test('profile rejects unauthenticated clients', async () => {
  const { app } = buildTestApp();

  const response = await request(app).get('/profile');

  assert.equal(response.status, 401);
  assert.deepEqual(response.body, { error: 'Authentication required' });
});

test('logout invalidates the authenticated session', async () => {
  const { app } = buildTestApp();
  const agent = request.agent(app);

  await agent.post('/auth/register').send(registration).expect(201);
  await agent
    .post('/auth/login')
    .send({ login: 'natalia', password: 'MyPassword123' })
    .expect(200);
  await agent.post('/auth/logout').expect(204);

  await agent.get('/profile').expect(401);
});
