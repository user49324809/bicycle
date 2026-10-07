export class FakeUserRepository {
  #users = [];
  #nextId = 1;

  async findByLogin(login) {
    return this.#users.find((user) => user.login === login) ?? null;
  }

  async findByLoginOrEmail(login, email) {
    return (
      this.#users.find(
        (user) => user.login === login || user.email === email,
      ) ?? null
    );
  }

  async findById(id) {
    return this.#users.find((user) => user.id === id) ?? null;
  }

  async create({
    login,
    email,
    passwordHash,
    passwordSalt,
    passwordIterations,
  }) {
    const existing = await this.findByLoginOrEmail(login, email);
    if (existing) {
      const error = new Error('Duplicate user');
      error.code = '23505';
      throw error;
    }

    const user = {
      id: this.#nextId++,
      login,
      email,
      passwordHash: Buffer.from(passwordHash),
      passwordSalt: Buffer.from(passwordSalt),
      passwordIterations,
    };

    this.#users.push(user);
    return user;
  }
}
