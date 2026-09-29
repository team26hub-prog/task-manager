<?php

class Task
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = require __DIR__ . '/../../config/database.php';
    }

    public function getAll(): array
    {
        $query = $this->connection->query(
            'SELECT tasks.id, tasks.title, tasks.description, tasks.status, tasks.priority,
                tasks.due_date, tasks.employee_id, tasks.created_at, tasks.updated_at,
                employees.name AS employee_name
            FROM tasks
            LEFT JOIN employees ON employees.id = tasks.employee_id
            ORDER BY tasks.created_at DESC'
        );

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title, ?string $description, string $status, string $priority, ?string $dueDate, ?int $employeeId): void
    {
        $query = $this->connection->prepare(
            'INSERT INTO tasks (title, description, status, priority, due_date, employee_id)
            VALUES (:title, :description, :status, :priority, :due_date, :employee_id)'
        );

        $query->execute([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'priority' => $priority,
            'due_date' => $dueDate,
            'employee_id' => $employeeId,
        ]);
    }

    public function updateStatus(int $taskId, string $status): void
    {
        $query = $this->connection->prepare('UPDATE tasks SET status = :status WHERE id = :id');
        $query->execute([
            'status' => $status,
            'id' => $taskId,
        ]);
    }

    public function assignEmployee(int $taskId, int $employeeId): void
    {
        $query = $this->connection->prepare('UPDATE tasks SET employee_id = :employee_id WHERE id = :id');
        $query->execute([
            'employee_id' => $employeeId,
            'id' => $taskId,
        ]);
    }
}