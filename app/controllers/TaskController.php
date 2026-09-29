<?php

require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Employee.php';

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
        $employeeValue = trim((string) ($data['employee_id'] ?? ''));
        $employeeId = null;

        if ($title === '') {
            throw new InvalidArgumentException('Please enter a task title.');
        }

        if (!in_array($status, ['pending', 'in_progress', 'completed'], true)) {
            throw new InvalidArgumentException('Please choose a valid task status.');
        }

        if (!in_array($priority, ['low', 'medium', 'high'], true)) {
            throw new InvalidArgumentException('Please choose a valid task priority.');
        }

        if ($employeeValue === '' || !ctype_digit($employeeValue) || !(new Employee())->exists((int) $employeeValue)) {
            throw new InvalidArgumentException('Please choose a valid employee for this task.');
        }
        $employeeId = (int) $employeeValue;

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
            $dueDate === '' ? null : $dueDate,
            $employeeId
        );
    }

    public function updateStatus(array $data): void
    {
        $taskId = (string) ($data['task_id'] ?? '');
        $status = (string) ($data['status'] ?? '');

        if (!ctype_digit($taskId) || (int) $taskId < 1) {
            throw new InvalidArgumentException('Please choose a valid task.');
        }

        if (!in_array($status, ['pending', 'in_progress', 'completed'], true)) {
            throw new InvalidArgumentException('Please choose a valid task status.');
        }

        (new Task())->updateStatus((int) $taskId, $status);
    }

    public function assignEmployee(array $data): void
    {
        $taskId = (string) ($data['task_id'] ?? '');
        $employeeId = (string) ($data['employee_id'] ?? '');

        if (!ctype_digit($taskId) || (int) $taskId < 1) {
            throw new InvalidArgumentException('Please choose a valid task.');
        }

        if (!ctype_digit($employeeId) || !(new Employee())->exists((int) $employeeId)) {
            throw new InvalidArgumentException('Please choose a valid employee.');
        }

        (new Task())->assignEmployee((int) $taskId, (int) $employeeId);
    }
}