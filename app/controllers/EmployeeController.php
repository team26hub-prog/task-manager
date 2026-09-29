<?php

require_once __DIR__ . '/../models/Employee.php';

class EmployeeController
{
    public function index(): array
    {
        return (new Employee())->getAll();
    }

    public function store(array $data): void
    {
        $name = trim((string) ($data['name'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $department = trim((string) ($data['department'] ?? ''));

        if ($name === '' || strlen($name) > 150) {
            throw new InvalidArgumentException('Enter an employee name up to 150 characters.');
        }

        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
            throw new InvalidArgumentException('Enter a valid email address.');
        }

        if ((new Employee())->emailExists($email)) {
            throw new InvalidArgumentException('This email address is already registered. Enter a different email.');
        }

        if (strlen($department) > 120) {
            throw new InvalidArgumentException('Department must be 120 characters or fewer.');
        }

        (new Employee())->create(
            $name,
            $email === '' ? null : $email,
            $department === '' ? null : $department
        );
    }
}
