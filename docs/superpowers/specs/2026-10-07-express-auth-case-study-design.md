# Express Authentication Case Study — Design

## Goal
Turn the existing `bicycle` repository into a reproducible companion project for the authentication article: preserve the original PHP bug as a documented case study, then provide a corrected Express/PostgreSQL implementation that can be tested locally.

## Audience
Technical editors, readers, and hiring reviewers who want to verify that the article is grounded in a real project and that the corrected authentication flow actually works.

## Scope
The repository will demonstrate:

- registration with server-side validation;
- parameterized PostgreSQL queries;
- unique login/email constraints at the database layer;
- PBKDF2-HMAC-SHA256 password derivation using `node:crypto`;
- per-user random salts;
- safe hash comparison with `timingSafeEqual`;
- session-based login with session-id regeneration;
- protected profile access;
- logout and session invalidation;
- automated tests for the critical authentication behavior;
- a written comparison with the original PHP mistake where a stored hash was compared with a plaintext password.

The repository is an educational case study, not a complete identity platform. Password reset, email verification, MFA, OAuth, account lockout, and role-based authorization are deliberately out of scope.

## Architecture

### Application boundary
`src/app.js` exports `createApp({ userRepository, sessionStore })`. Routes depend on a small user-repository interface rather than directly on PostgreSQL. This keeps HTTP behavior testable without a running database.

### Password module
`src/auth/password.js` owns PBKDF2 parameters, salt generation, derivation, and verification. Passwords are never logged or stored in plaintext.

### User repositories
`src/users/postgresUserRepository.js` implements the production repository using parameterized `pg` queries. Tests use `tests/helpers/fakeUserRepository.js`, which implements the same interface in memory.

Required repository methods:

- `findByLogin(login)`
- `findByLoginOrEmail(login, email)`
- `findById(id)`
- `create({ login, email, passwordHash, passwordSalt, passwordIterations })`

### Session handling
The application uses `express-session`. Tests may use its in-memory store because the process is short-lived. Production startup uses a PostgreSQL-backed session store; the README explicitly states that the default MemoryStore is not a production option.

### Database
`migrations/001_users.sql` defines the `users` table with a primary key, `UNIQUE` constraints on login and email, PBKDF2 fields, and creation timestamp.

## HTTP behavior

### POST /auth/register
Accepts `login`, `email`, and `password`.

- `400` when required values are missing or malformed.
- `409` when login or email already exists.
- Stores only password-derived data, never the plaintext password.
- `201` with a minimal public user object on success.

### POST /auth/login
Accepts `login` and `password`.

- `400` when required values are missing.
- `401` with the same `Invalid login or password` message for an unknown login or a wrong password.
- Regenerates the session ID before storing `userId`.
- `200` on success.

### GET /profile
Requires an authenticated session.

- `401` without a valid session.
- Returns only public user fields on success.

### POST /auth/logout
Destroys the server-side session and clears the session cookie.

## Security constraints

- Do not trim or HTML-sanitize passwords before hashing or verification.
- Use random 16-byte salts.
- Use asynchronous PBKDF2.
- Use `timingSafeEqual` only after checking equal buffer lengths.
- Use parameterized SQL everywhere.
- Keep `SESSION_SECRET` outside source control.
- Set `httpOnly` and `sameSite=lax`; set `secure` in production.
- Regenerate the session identifier after successful authentication.
- Never store password or password hash in the session.
- Use generic login failure messages.

## Tests
The automated suite must prove at least:

1. equal plaintext passwords produce different stored hashes because salts differ;
2. a correct password verifies and a wrong password does not;
3. registration stores derived password data rather than plaintext;
4. duplicate registration returns `409`;
5. wrong login credentials return `401`;
6. successful login establishes a session that can access `/profile`;
7. `/profile` returns `401` without authentication;
8. logout invalidates the authenticated session.

## Documentation

- `README.md`: purpose, architecture, setup, endpoints, security decisions, test command, and article relationship.
- `docs/original-php-bug.md`: the original registration/login mismatch, why it failed, and the corrected PHP/Express verification models.
- `.env.example`: non-secret configuration keys only.

## Success criteria
A reviewer can clone the repository, install dependencies, run the test suite successfully, inspect the migration and parameterized queries, and understand exactly how the old PHP bug led to the corrected Express implementation.