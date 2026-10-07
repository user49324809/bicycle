import { readFile } from 'node:fs/promises';
import { loadConfig } from '../config.js';
import { createPool } from './pool.js';

const config = loadConfig();
const pool = createPool(config.databaseUrl);

try {
  const sql = await readFile(
    new URL('../../migrations/001_users.sql', import.meta.url),
    'utf8',
  );
  await pool.query(sql);
  console.log('Migration complete');
} finally {
  await pool.end();
}
