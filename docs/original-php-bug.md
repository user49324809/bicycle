# Original PHP authentication bug

This document preserves the authentication mistake that motivated the Express rewrite.

The code came from an older bicycle-store project. The registration path and login path each looked plausible when read separately, but they used incompatible representations of the password.

## Registration: the good part

The registration handler derived a password hash before inserting the user:

```php
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO `registr` (login, email, pass) VALUES (?, ?, ?)"
);
$stmt->bind_param("sss", $login, $email, $hashedPass);
```

That meant MySQL received a password hash rather than the plaintext password.

## Login: the broken comparison

The login handler calculated a new hash but did not use it:

```php
$hashedPass = password_hash($pass, PASSWORD_DEFAULT);
```

It then built a query that compared the stored `pass` column with the plaintext password from the form:

```php
$sql = "SELECT * FROM `registr` WHERE login = '$login' AND pass = '$pass'";
```

Conceptually, the application was asking:

```text
$2y$10$... == MyPassword123
```

A stored password hash and a plaintext password are not comparable as ordinary strings, so a user registered through the hashing flow cannot authenticate this way.

The unused `$hashedPass` variable also would not fix the logic simply by being substituted into the query. Modern password hashing functions use salts, so generating a fresh hash is not a general string-equality verification strategy.

The query has a second independent problem: user input is interpolated directly into SQL. Sanitizing HTML characters is not a replacement for a prepared statement.

## Correct PHP verification model

A corrected PHP flow first retrieves the account with a prepared statement, then asks `password_verify()` to verify the candidate password against the stored hash:

```php
$stmt = $conn->prepare(
    "SELECT login, email, pass FROM registr WHERE login = ?"
);
$stmt->bind_param("s", $login);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($pass, $user['pass'])) {
    session_regenerate_id(true);
    $_SESSION['login'] = $user['login'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['user_logged_in'] = true;
}
```

The important change is the sequence:

```text
find account
    ↓
read stored password hash
    ↓
verify candidate password against that hash
    ↓
authenticate only if verification succeeds
```

## The same idea in the Express rewrite

The Express version in this repository uses PBKDF2 instead of PHP's `password_hash()` API, so the mechanics are explicit.

Registration stores:

```text
passwordHash
passwordSalt
passwordIterations
```

Login retrieves those values and derives a candidate key from the newly supplied password using the saved salt and iteration count:

```text
candidate password
      +
stored salt
      +
stored PBKDF2 parameters
      ↓
PBKDF2
      ↓
candidate derived key
      ↓
timingSafeEqual(stored key, candidate key)
```

The lesson is broader than PHP versus Node.js: the storage step and the verification step must be parts of the same authentication protocol.

## Other issues found while reviewing the old project

The old code also provides useful examples of mistakes that are separate from the hash/plaintext mismatch:

- passwords were run through HTML-oriented sanitization before authentication;
- SQL values were interpolated directly in the login query;
- a password/hash value was copied into session state even though the session did not need it;
- database credentials were hard-coded in the project;
- application-level duplicate checks were not backed by database `UNIQUE` constraints.

Those findings are why the rewrite separates password handling, persistence, and session state instead of treating login as one SQL condition.
