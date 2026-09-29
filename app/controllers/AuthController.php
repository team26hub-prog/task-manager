<?php

require_once __DIR__ . '/../models/User.php';

class AuthController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function hasAdmin(): bool
    {
        return $this->userModel->count() > 0;
    }

    public function createFirstAdmin(array $data): array
    {
        if ($this->hasAdmin()) {
            throw new InvalidArgumentException('Admin setup is already complete. Please log in.');
        }

        $name = trim((string) ($data['full_name'] ?? ''));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $password = (string) ($data['password'] ?? '');
        $passwordConfirmation = (string) ($data['password_confirmation'] ?? '');

        if ($name === '' || strlen($name) > 150) {
            throw new InvalidArgumentException('Enter your name (up to 150 characters).');
        }

        if (!$this->hasValidEmailFormat($email)) {
            throw new InvalidArgumentException('Enter a valid email address.');
        }

        if (strlen($password) < 8 || strlen($password) > 255) {
            throw new InvalidArgumentException('Password must be at least 8 characters.');
        }

        if ($password !== $passwordConfirmation) {
            throw new InvalidArgumentException('Passwords do not match.');
        }

        $userId = $this->userModel->create($name, $email, password_hash($password, PASSWORD_DEFAULT));

        return [
            'id' => $userId,
            'full_name' => $name,
            'email' => $email,
        ];
    }

    public function login(array $data): array
    {
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $password = (string) ($data['password'] ?? '');

        if ($email === '') {
            throw new InvalidArgumentException('Please enter a valid email address.');
        }

        if (!$this->hasValidEmailFormat($email)) {
            throw new InvalidArgumentException('Please enter a valid email address.');
        }

        if ($password === '') {
            throw new InvalidArgumentException('Enter your password.');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            throw new InvalidArgumentException('Email or password is incorrect.');
        }

        unset($user['password_hash']);
        return $user;
    }

    private function hasValidEmailFormat(string $email): bool
    {
        return strlen($email) <= 190
            && filter_var($email, FILTER_VALIDATE_EMAIL) !== false
            && preg_match('/^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+(?:com|org|net|edu|gov|mil|int|info|biz|name|pro|aero|asia|cat|coop|jobs|mobi|museum|travel|xyz|online|site|store|tech|app|dev|io|ai|me|tv|co|[A-Z]{2})$/i', $email) === 1;
    }
}
