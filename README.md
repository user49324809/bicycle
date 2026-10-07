# Bicycle Authentication Case Study

A small, reproducible authentication project built from a real bug I found in an older PHP bicycle-store project.

The original project already hashed passwords during registration, but its login flow compared the stored hash with the plaintext password from the form. The result looked secure at a glance — passwords were hashed in MySQL — but authentication could not work correctly.

This repository keeps that mistake as a documented case study and rebuilds the flow with Express, PostgreSQL, PBKDF2, parameterized queries, and server-side sessions.

## What this demonstrates

- server-side registration validation;
- unique login/email constraints in PostgreSQL;
- parameterized SQL queries with `pg`;
- asynchronous PBKDF2-HMAC-SHA256 using `node:crypto`;
- random per-user salts;
- safe derived-key comparison with `timingSafeEqual`;
- generic login failures for unknown users and wrong passwords;
- session-id regeneration after successful authentication;
- protected routes and logout;
- PostgreSQL-backed sessions created through migrations rather than runtime DDL;
- automated HTTP, password, configuration, and persistence tests.

## The original bug

Registration stored a password hash, while login effectively tried to do this:

```text
stored_hash == plaintext_password
```

Those are different representations and cannot be compared as ordinary strings.

The historical PHP code and a corrected PHP version are documented in [`docs/original-php-bug.md`](docs/original-php-bug.md).

## Architecture

```text
Browser / API client
        |
        v
    Express app
   /           \
password      session
module        middleware
   |             |
   v             v
PBKDF2       userId only
        \
         v
   UserRepository
      /      \
 test fake   PostgreSQL
                |
                v
        users + sessions
```

The HTTP layer depends on a small repository interface instead of importing PostgreSQL directly. Tests use an in-memory implementation; production uses `src/users/postgresUserRepository.js`.

## Project layout

```text
src/
├── app.js
├── config.js
├── server.js
├── auth/
│   └── password.js
├── db/
│   ├── migrate.js
│   └── pool.js
└── users/
    └── postgresUserRepository.js

migrations/
├── 001_users.sql
└── 002_sessions.sql

tests/
├── auth.test.js
├── config.test.js
├── password.test.js
├── persistence.test.js
└── helpers/
    └── fakeUserRepository.js

docs/
└── original-php-bug.md
```

## Run locally

Requirements:

- Node.js 22+
- PostgreSQL

Install dependencies:

```bash
npm install
```

Create a local environment file:

```bash
cp .env.example .env
```

Edit `DATABASE_URL` and replace `SESSION_SECRET` with your own random value of at least 32 characters. The placeholder in `.env.example` is intentionally too short, so the application refuses to start until it is replaced.

Create the database, then apply both migrations:

```bash
npm run migrate
```

`001_users.sql` creates the user table and its uniqueness constraints. `002_sessions.sql` creates the `user_sessions` table used by `connect-pg-simple`.

Start the API:

```bash
npm start
```

By default it listens on port `3000`.

## API

### `POST /auth/register`

```json
{
  "login": "natalia",
  "email": "natalia@example.com",
  "password": "MyPassword123"
}
```

Returns `201` on success, `400` for invalid input, and `409` when login or email already exists.

### `POST /auth/login`

```json
{
  "login": "natalia",
  "password": "MyPassword123"
}
```

Returns the same `401` response for an unknown login and an incorrect password.

### `GET /profile`

Requires an authenticated session and returns public user data only.

### `POST /auth/logout`

Destroys the server-side session and clears the session cookie.

## Tests

```bash
npm test
```

The suite checks the behaviors that matter most to this case study:

- the same plaintext password produces different hashes because salts differ;
- a correct password verifies and a wrong password does not;
- registration never stores a plaintext password;
- duplicate identities return `409`;
- wrong credentials return a generic `401`;
- successful login creates a reusable authenticated session;
- protected routes reject anonymous requests;
- logout invalidates the session;
- the SQL adapter uses placeholders and the schema enforces uniqueness;
- session storage is created by migrations rather than by the application process at startup.

## Security decisions

### Passwords are opaque input

The password is not trimmed and is not HTML-sanitized before hashing or verification. Changing a password before verification changes the credential itself.

### Password derivation

This case study uses asynchronous PBKDF2-HMAC-SHA256 with a random 16-byte salt and stores the iteration count alongside the derived value. The current example uses `600000` iterations because it matches the article's PBKDF2 example; production parameters should always be checked against current guidance and measured on the actual deployment environment.

For a brand-new system, also evaluate memory-hard password hashing such as Argon2id rather than choosing PBKDF2 automatically.

### Database constraints matter

The application checks for an existing login/email to return a friendly `409`, but PostgreSQL `UNIQUE` constraints are the actual race-safe guarantee.

### Session handling

After password verification, the application regenerates the session ID and stores only `userId` in the session. Passwords and password hashes are not session data.

Production startup uses `connect-pg-simple`. The `user_sessions` table is created by `002_sessions.sql`, and `createTableIfMissing` is disabled in the running server. This keeps schema creation in the migration step instead of requiring the application process to create tables at runtime. Express's default in-memory session store is intentionally not used as the production store.

### SQL

User-controlled values are passed to `pg` separately from SQL text through `$1`, `$2`, and other placeholders.

## Deliberately out of scope

This is a focused authentication case study, not a complete identity platform. It does not implement:

- password reset;
- email verification;
- MFA;
- OAuth/social login;
- role-based authorization;
- account lockout;
- a complete rate-limiting strategy.

Those concerns matter in production, but including them here would hide the bug this repository is meant to explain.

## Why this repository exists

The useful lesson from the original project was not simply "hash passwords." The password was already hashed.

The real lesson was that authentication is a chain of compatible steps. If registration stores one representation and login verifies another incorrectly, one broken comparison can invalidate the whole flow.

This repository is the executable companion to that lesson.
