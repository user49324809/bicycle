import { pbkdf2, randomBytes, timingSafeEqual } from 'node:crypto';
import { promisify } from 'node:util';

const pbkdf2Async = promisify(pbkdf2);

export const PBKDF2_ITERATIONS = 600_000;
export const PBKDF2_KEY_LENGTH = 32;
export const PBKDF2_DIGEST = 'sha256';
export const PASSWORD_SALT_BYTES = 16;

async function derive(password, salt, iterations) {
  return pbkdf2Async(
    password,
    salt,
    iterations,
    PBKDF2_KEY_LENGTH,
    PBKDF2_DIGEST,
  );
}

export async function hashPassword(password) {
  if (typeof password !== 'string' || password.length === 0) {
    throw new TypeError('Password must be a non-empty string');
  }

  const passwordSalt = randomBytes(PASSWORD_SALT_BYTES);
  const passwordHash = await derive(
    password,
    passwordSalt,
    PBKDF2_ITERATIONS,
  );

  return {
    passwordHash,
    passwordSalt,
    passwordIterations: PBKDF2_ITERATIONS,
  };
}

export async function verifyPassword(password, record) {
  if (
    typeof password !== 'string' ||
    !record ||
    !Buffer.isBuffer(record.passwordHash) ||
    !Buffer.isBuffer(record.passwordSalt) ||
    !Number.isInteger(record.passwordIterations) ||
    record.passwordIterations <= 0
  ) {
    return false;
  }

  const candidateHash = await derive(
    password,
    record.passwordSalt,
    record.passwordIterations,
  );

  return (
    record.passwordHash.length === candidateHash.length &&
    timingSafeEqual(record.passwordHash, candidateHash)
  );
}
