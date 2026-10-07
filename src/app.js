import express from 'express';
import session from 'express-session';
import { hashPassword, verifyPassword } from './auth/password.js';

const LOGIN_ERROR = { error: 'Invalid login or password' };
const AUTH_REQUIRED = { error: 'Authentication required' };

function publicUser(user) {
  return {
    id: user.id,
    login: user.login,
    email: user.email,
  };
}

function parseRegistration(body) {
  const login = typeof body?.login === 'string' ? body.login.trim() : '';
  const email =
    typeof body?.email === 'string' ? body.email.trim().toLowerCase() : '';
  const password = typeof body?.password === 'string' ? body.password : '';

  const emailLooksValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

  if (!login || !emailLooksValid || !password) {
    return null;
  }

  return { login, email, password };
}

function parseLogin(body) {
  const login = typeof body?.login === 'string' ? body.login.trim() : '';
  const password = typeof body?.password === 'string' ? body.password : '';

  if (!login || !password) {
    return null;
  }

  return { login, password };
}

function regenerateSession(req) {
  return new Promise((resolve, reject) => {
    req.session.regenerate((error) => (error ? reject(error) : resolve()));
  });
}

function saveSession(req) {
  return new Promise((resolve, reject) => {
    req.session.save((error) => (error ? reject(error) : resolve()));
  });
}

function destroySession(req) {
  return new Promise((resolve, reject) => {
    req.session.destroy((error) => (error ? reject(error) : resolve()));
  });
}

function requireAuth(req, res, next) {
  if (!req.session.userId) {
    return res.status(401).json(AUTH_REQUIRED);
  }

  return next();
}

export function createApp({
  userRepository,
  sessionStore,
  sessionSecret,
  isProduction = false,
}) {
  if (!userRepository) {
    throw new Error('userRepository is required');
  }
  if (!sessionSecret) {
    throw new Error('sessionSecret is required');
  }

  const app = express();
  if (isProduction) {
    app.set('trust proxy', 1);
  }

  app.disable('x-powered-by');
  app.use(express.json({ limit: '16kb' }));

  const sessionOptions = {
    name: 'sid',
    secret: sessionSecret,
    resave: false,
    saveUninitialized: false,
    cookie: {
      httpOnly: true,
      secure: isProduction,
      sameSite: 'lax',
      maxAge: 60 * 60 * 1000,
    },
  };

  if (sessionStore) {
    sessionOptions.store = sessionStore;
  }

  app.use(session(sessionOptions));

  app.post('/auth/register', async (req, res, next) => {
    try {
      const input = parseRegistration(req.body);
      if (!input) {
        return res.status(400).json({
          error: 'Login, valid email and password are required',
        });
      }

      const existing = await userRepository.findByLoginOrEmail(
        input.login,
        input.email,
      );
      if (existing) {
        return res.status(409).json({ error: 'User already exists' });
      }

      const passwordRecord = await hashPassword(input.password);

      try {
        const user = await userRepository.create({
          login: input.login,
          email: input.email,
          ...passwordRecord,
        });

        return res.status(201).json({ user: publicUser(user) });
      } catch (error) {
        if (error?.code === '23505') {
          return res.status(409).json({ error: 'User already exists' });
        }
        throw error;
      }
    } catch (error) {
      return next(error);
    }
  });

  app.post('/auth/login', async (req, res, next) => {
    try {
      const input = parseLogin(req.body);
      if (!input) {
        return res.status(400).json({
          error: 'Login and password are required',
        });
      }

      const user = await userRepository.findByLogin(input.login);
      if (!user) {
        return res.status(401).json(LOGIN_ERROR);
      }

      const passwordIsCorrect = await verifyPassword(input.password, user);
      if (!passwordIsCorrect) {
        return res.status(401).json(LOGIN_ERROR);
      }

      await regenerateSession(req);
      req.session.userId = user.id;
      await saveSession(req);

      return res.status(200).json({
        message: 'Authentication successful',
        user: publicUser(user),
      });
    } catch (error) {
      return next(error);
    }
  });

  app.get('/profile', requireAuth, async (req, res, next) => {
    try {
      const user = await userRepository.findById(req.session.userId);
      if (!user) {
        await destroySession(req);
        return res.status(401).json(AUTH_REQUIRED);
      }

      return res.status(200).json({ user: publicUser(user) });
    } catch (error) {
      return next(error);
    }
  });

  app.post('/auth/logout', async (req, res, next) => {
    try {
      if (req.session) {
        await destroySession(req);
      }

      res.clearCookie('sid', {
        httpOnly: true,
        secure: isProduction,
        sameSite: 'lax',
        path: '/',
      });
      return res.status(204).end();
    } catch (error) {
      return next(error);
    }
  });

  app.use((error, req, res, next) => {
    if (res.headersSent) {
      return next(error);
    }

    return res.status(500).json({ error: 'Internal server error' });
  });

  return app;
}
