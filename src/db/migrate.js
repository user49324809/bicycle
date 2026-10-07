import { readFile } from 'node:fs/promises';
import { loadConfig } from '../config.js';
import { createPool } from './pool.js';

const config = loadConfig();
const pool = createPool(config.databaseUrl);
const migrations = ['001_users.sql', '002_sessions.sql'];

try {
  for (const filename of migrations) {
    const sql = await readFile(
      new URL(`../../migrations/${filename}`, import.meta.url),
      'utf8',
    );
    await pool.query(sql);
  }
  console.log('Migrations complete');
} finally {
  await pool.end();
}
