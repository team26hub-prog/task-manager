<?php

class User
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = require __DIR__ . '/../../config/database.php';
    }

    public function count(): int
    {
        return (int) $this->connection->query('SELECT COUNT(*) FROM users')->fetchColumn();
    }

    public function findByEmail(string $email): ?array
    {
        $query = $this->connection->prepare(
            'SELECT id, full_name, email, password_hash FROM users WHERE email = :email LIMIT 1'
        );
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function create(string $name, string $email, string $passwordHash): int
    {
        $query = $this->connection->prepare(
            'INSERT INTO users (full_name, email, password_hash)
            VALUES (:full_name, :email, :password_hash)'
        );
        $query->execute([
            'full_name' => $name,
            'email' => $email,
            'password_hash' => $passwordHash,
        ]);

        return (int) $this->connection->lastInsertId();
    }
}
