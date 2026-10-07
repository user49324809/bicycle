import session from 'express-session';
import connectPgSimple from 'connect-pg-simple';
import { createApp } from './app.js';
import { loadConfig } from './config.js';
import { createPool } from './db/pool.js';
import { createPostgresUserRepository } from './users/postgresUserRepository.js';

const config = loadConfig();
const pool = createPool(config.databaseUrl);
const userRepository = createPostgresUserRepository(pool);
const PgSession = connectPgSimple(session);
const sessionStore = new PgSession({
  pool,
  tableName: 'user_sessions',
  createTableIfMissing: true,
});

const app = createApp({
  userRepository,
  sessionStore,
  sessionSecret: config.sessionSecret,
  isProduction: config.isProduction,
});

const server = app.listen(config.port, () => {
  console.log(`Server listening on port ${config.port}`);
});

async function shutdown(signal) {
  console.log(`${signal} received, shutting down`);
  server.close(async () => {
    await pool.end();
    process.exit(0);
  });
}

process.on('SIGTERM', () => shutdown('SIGTERM'));
process.on('SIGINT', () => shutdown('SIGINT'));
