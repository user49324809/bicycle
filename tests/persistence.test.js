import test from 'node:test';
import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';

const repositoryUrl = new URL('../src/users/postgresUserRepository.js', import.meta.url);
const migrationUrl = new URL('../migrations/001_users.sql', import.meta.url);
const sessionMigrationUrl = new URL('../migrations/002_sessions.sql', import.meta.url);
const serverUrl = new URL('../src/server.js', import.meta.url);
const migrateUrl = new URL('../src/db/migrate.js', import.meta.url);

test('PostgreSQL repository uses placeholders for user-controlled values', async () => {
  const source = await readFile(repositoryUrl, 'utf8');

  assert.match(source, /WHERE login = \$1/);
  assert.match(source, /login = \$1 OR email = \$2/);
  assert.match(source, /VALUES \(\$1, \$2, \$3, \$4, \$5\)/);
  assert.doesNotMatch(source, /WHERE login = ['"]\s*\+/);
});

test('users migration enforces primary key and unique login/email', async () => {
  const sql = await readFile(migrationUrl, 'utf8');

  assert.match(sql, /PRIMARY KEY/i);
  assert.match(sql, /login\s+TEXT\s+NOT NULL\s+UNIQUE/i);
  assert.match(sql, /email\s+TEXT\s+NOT NULL\s+UNIQUE/i);
  assert.match(sql, /password_hash\s+BYTEA\s+NOT NULL/i);
  assert.match(sql, /password_salt\s+BYTEA\s+NOT NULL/i);
});

test('session table is migration-managed instead of created at runtime', async () => {
  const [sessionSql, serverSource, migrateSource] = await Promise.all([
    readFile(sessionMigrationUrl, 'utf8'),
    readFile(serverUrl, 'utf8'),
    readFile(migrateUrl, 'utf8'),
  ]);

  assert.match(sessionSql, /CREATE TABLE IF NOT EXISTS user_sessions/i);
  assert.match(sessionSql, /PRIMARY KEY \(sid\)/i);
  assert.match(serverSource, /createTableIfMissing:\s*false/);
  assert.match(migrateSource, /002_sessions\.sql/);
});
