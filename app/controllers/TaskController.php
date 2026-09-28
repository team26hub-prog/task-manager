<?php

require_once __DIR__ . '/../models/Task.php';

class TaskController
{
    public function index(): array
    {
        $taskModel = new Task();
        return $taskModel->getAll();
    }

    public function store(array $data): void
    {
        $title = trim((string) ($data['title'] ?? ''));
        $description = trim((string) ($data['description'] ?? ''));
        $status = (string) ($data['status'] ?? 'pending');
        $priority = (string) ($data['priority'] ?? 'medium');
        $dueDate = trim((string) ($data['due_date'] ?? ''));

        if ($title === '') {
            throw new InvalidArgumentException('Please enter a task title.');
        }

        if (!in_array($status, ['pending', 'in_progress', 'completed'], true)) {
            throw new InvalidArgumentException('Please choose a valid task status.');
        }

        if (!in_array($priority, ['low', 'medium', 'high'], true)) {
            throw new InvalidArgumentException('Please choose a valid task priority.');
        }

        if ($dueDate !== '') {
            $date = DateTimeImmutable::createFromFormat('!Y-m-d', $dueDate);
            if (!$date || $date->format('Y-m-d') !== $dueDate) {
                throw new InvalidArgumentException('Please enter a valid due date.');
            }
        }

        $taskModel = new Task();
        $taskModel->create(
            $title,
            $description === '' ? null : $description,
            $status,
            $priority,
            $dueDate === '' ? null : $dueDate
        );
    }
}