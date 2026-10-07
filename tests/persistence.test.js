import test from 'node:test';
import assert from 'node:assert/strict';
import { readFile } from 'node:fs/promises';

const repositoryUrl = new URL('../src/users/postgresUserRepository.js', import.meta.url);
const migrationUrl = new URL('../migrations/001_users.sql', import.meta.url);

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
