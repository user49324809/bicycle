# Express Authentication Case Study Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Build a runnable Express/PostgreSQL authentication case study that reproduces the article's corrected flow and documents the original PHP verification bug.

**Architecture:** HTTP routes live in `src/app.js` and depend on a repository interface. Password derivation and verification live in `src/auth/password.js`. Production uses a PostgreSQL repository, while tests use an in-memory fake so critical behavior can run without external services.

**Tech Stack:** Node.js 22+, Express, `node:crypto`, PostgreSQL/`pg`, `express-session`, Node test runner, Supertest.

**Spec:** `docs/superpowers/specs/2026-10-07-express-auth-case-study-design.md`

## Global Constraints

- Passwords are treated as opaque strings: no trimming or HTML sanitization.
- PBKDF2 uses asynchronous `node:crypto` calls, 16-byte random salts, HMAC-SHA256, 600000 iterations, and 32-byte derived keys.
- SQL is parameterized.
- Login failures use the same public error for unknown users and incorrect passwords.
- Session identifiers are regenerated after successful authentication.
- Tests must not require a running PostgreSQL server.

## Review Focus

- Missing/non-string request fields return controlled `400` responses rather than throwing.
- Duplicate login or email returns `409` and never overwrites an existing user.
- Wrong-password verification never succeeds and equal-length checks precede `timingSafeEqual`.
- Session-only routes reject unauthenticated clients and no credential material is written to sessions.
- PostgreSQL repository methods use placeholders for every user-controlled value.

---

### Task 1: Password derivation and verification

**Files:**
- Create: `src/auth/password.js`
- Create: `tests/password.test.js`

**Interfaces:**
- Produces: `hashPassword(password)` and `verifyPassword(password, record)`.

- [ ] Write failing tests proving same plaintext produces different salts/hashes, correct passwords verify, and wrong passwords fail.
- [ ] Run `npm test -- tests/password.test.js` and verify failure because the module does not exist.
- [ ] Implement the minimal asynchronous PBKDF2 functions.
- [ ] Re-run the password tests and verify they pass.

### Task 2: Testable registration and login flow

**Files:**
- Create: `src/app.js`
- Create: `tests/helpers/fakeUserRepository.js`
- Create: `tests/auth.test.js`

**Interfaces:**
- Consumes: `hashPassword`, `verifyPassword`.
- Produces: `createApp({ userRepository, sessionStore })` and the repository method contract from the spec.

- [ ] Write failing HTTP tests for registration, duplicate registration, generic login failure, successful session login, protected profile access, and logout invalidation.
- [ ] Run the auth test file and verify the expected missing-module/behavior failures.
- [ ] Implement the fake repository and minimal Express routes/middleware to satisfy the tests.
- [ ] Run the complete suite and verify all tests pass.

### Task 3: PostgreSQL persistence

**Files:**
- Create: `src/db/pool.js`
- Create: `src/users/postgresUserRepository.js`
- Create: `migrations/001_users.sql`
- Create: `.env.example`

**Interfaces:**
- Produces the same repository methods consumed by `createApp`.

- [ ] Add a static repository contract test that checks SQL uses placeholders and the migration carries primary/unique constraints.
- [ ] Run the test and verify it fails because persistence files are missing.
- [ ] Implement the PostgreSQL pool, repository, migration, and environment template.
- [ ] Run the suite and verify all tests pass.

### Task 4: Production startup and session store

**Files:**
- Create: `src/server.js`
- Modify: `package.json`

**Interfaces:**
- Consumes: `createApp`, PostgreSQL pool/repository.

- [ ] Write a configuration test that production startup requires `SESSION_SECRET` and does not silently rely on the default session secret.
- [ ] Run it and verify the expected failure.
- [ ] Add startup wiring and scripts. Keep MemoryStore limited to tests/development and document the production store requirement.
- [ ] Run the entire suite.

### Task 5: Case-study documentation

**Files:**
- Replace: `README.md`
- Create: `docs/original-php-bug.md`

**Interfaces:**
- Documents the code implemented by Tasks 1-4 and the historical PHP bug.

- [ ] Document the original `password_hash()`/plaintext comparison mismatch without presenting insecure code as a recommendation.
- [ ] Document setup, endpoints, architecture, testing, security choices, and production limitations.
- [ ] Verify all paths and commands in the README match the repository.
- [ ] Run the full test suite one final time.