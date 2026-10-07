export function createPostgresUserRepository(pool) {
  if (!pool) {
    throw new Error('PostgreSQL pool is required');
  }

  const selectFields = `
    id,
    login,
    email,
    password_hash AS "passwordHash",
    password_salt AS "passwordSalt",
    password_iterations AS "passwordIterations"
  `;

  return {
    async findByLogin(login) {
      const result = await pool.query(
        `SELECT ${selectFields} FROM users WHERE login = $1 LIMIT 1`,
        [login],
      );
      return result.rows[0] ?? null;
    },

    async findByLoginOrEmail(login, email) {
      const result = await pool.query(
        `SELECT ${selectFields} FROM users WHERE login = $1 OR email = $2 LIMIT 1`,
        [login, email],
      );
      return result.rows[0] ?? null;
    },

    async findById(id) {
      const result = await pool.query(
        `SELECT ${selectFields} FROM users WHERE id = $1 LIMIT 1`,
        [id],
      );
      return result.rows[0] ?? null;
    },

    async create({
      login,
      email,
      passwordHash,
      passwordSalt,
      passwordIterations,
    }) {
      const result = await pool.query(
        `
          INSERT INTO users (
            login,
            email,
            password_hash,
            password_salt,
            password_iterations
          )
          VALUES ($1, $2, $3, $4, $5)
          RETURNING ${selectFields}
        `,
        [login, email, passwordHash, passwordSalt, passwordIterations],
      );

      return result.rows[0];
    },
  };
}
