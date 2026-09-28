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
            'SELECT id, title, description, status, priority, due_date, created_at, updated_at
            FROM tasks
            ORDER BY created_at DESC'
        );

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(string $title, ?string $description, string $status, string $priority, ?string $dueDate): void
    {
        $query = $this->connection->prepare(
            'INSERT INTO tasks (title, description, status, priority, due_date)
            VALUES (:title, :description, :status, :priority, :due_date)'
        );

        $query->execute([
            'title' => $title,
            'description' => $description,
            'status' => $status,
            'priority' => $priority,
            'due_date' => $dueDate,
        ]);
    }
}