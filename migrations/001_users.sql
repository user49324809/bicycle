CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    login TEXT NOT NULL UNIQUE,
    email TEXT NOT NULL UNIQUE,
    password_hash BYTEA NOT NULL,
    password_salt BYTEA NOT NULL,
    password_iterations INTEGER NOT NULL CHECK (password_iterations > 0),
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);
