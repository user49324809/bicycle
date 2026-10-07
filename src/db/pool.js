import pg from 'pg';

const { Pool } = pg;

export function createPool(databaseUrl) {
  if (!databaseUrl) {
    throw new Error('databaseUrl is required');
  }

  return new Pool({ connectionString: databaseUrl });
}
