import test from 'node:test';
import assert from 'node:assert/strict';
import { loadConfig } from '../src/config.js';

test('configuration rejects a missing SESSION_SECRET', () => {
  assert.throws(
    () => loadConfig({ DATABASE_URL: 'postgresql://localhost/test' }),
    /SESSION_SECRET/,
  );
});

test('configuration rejects a short SESSION_SECRET', () => {
  assert.throws(
    () =>
      loadConfig({
        DATABASE_URL: 'postgresql://localhost/test',
        SESSION_SECRET: 'too-short',
      }),
    /at least 32 characters/,
  );
});

test('configuration exposes normalized runtime values', () => {
  const config = loadConfig({
    PORT: '4100',
    NODE_ENV: 'production',
    DATABASE_URL: 'postgresql://localhost/test',
    SESSION_SECRET: '0123456789abcdef0123456789abcdef',
  });

  assert.deepEqual(config, {
    port: 4100,
    nodeEnv: 'production',
    isProduction: true,
    databaseUrl: 'postgresql://localhost/test',
    sessionSecret: '0123456789abcdef0123456789abcdef',
  });
});
