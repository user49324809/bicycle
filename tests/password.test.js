import test from 'node:test';
import assert from 'node:assert/strict';
import { hashPassword, verifyPassword } from '../src/auth/password.js';

test('same plaintext password produces different salts and hashes', async () => {
  const first = await hashPassword('correct horse battery staple');
  const second = await hashPassword('correct horse battery staple');

  assert.notDeepEqual(first.passwordSalt, second.passwordSalt);
  assert.notDeepEqual(first.passwordHash, second.passwordHash);
});

test('correct password verifies and wrong password fails', async () => {
  const record = await hashPassword('MyPassword123');

  assert.equal(await verifyPassword('MyPassword123', record), true);
  assert.equal(await verifyPassword('WrongPassword', record), false);
});
