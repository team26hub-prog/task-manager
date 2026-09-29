<?php

class Employee
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = require __DIR__ . '/../../config/database.php';
    }

    public function getAll(): array
    {
        $query = $this->connection->query(
            'SELECT employees.id, employees.name, employees.email, employees.department,
                employees.created_at, COUNT(tasks.id) AS task_count,
                SUM(CASE WHEN tasks.status = "completed" THEN 1 ELSE 0 END) AS completed_count
            FROM employees
            LEFT JOIN tasks ON tasks.employee_id = employees.id
            GROUP BY employees.id, employees.name, employees.email, employees.department, employees.created_at
            ORDER BY employees.name'
        );

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exists(int $employeeId): bool
    {
        $query = $this->connection->prepare('SELECT id FROM employees WHERE id = :id');
        $query->execute(['id' => $employeeId]);

        return (bool) $query->fetchColumn();
    }

    public function emailExists(string $email): bool
    {
        $query = $this->connection->prepare('SELECT id FROM employees WHERE email = :email');
        $query->execute(['email' => $email]);

        return (bool) $query->fetchColumn();
    }

    public function create(string $name, ?string $email, ?string $department): void
    {
        $query = $this->connection->prepare(
            'INSERT INTO employees (name, email, department)
            VALUES (:name, :email, :department)'
        );
        $query->execute([
            'name' => $name,
            'email' => $email,
            'department' => $department,
        ]);
    }
}
