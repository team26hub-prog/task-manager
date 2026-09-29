<?php

$basePath = is_dir(__DIR__ . '/app')
    ? __DIR__
    : dirname(__DIR__);

require_once $basePath . '/app/controllers/TaskController.php';

$pages = [
    'dashboard' => $basePath . '/app/views/dashboard/index.php',
    'tasks' => $basePath . '/app/views/tasks/index.php',
    'add-task' => $basePath . '/app/views/tasks/create.php',
    'reports' => $basePath . '/app/views/reports/index.php',
    'settings' => $basePath . '/app/views/settings/index.php',
];

$page = (string) ($_GET['page'] ?? 'dashboard');

if (!isset($pages[$page])) {
    http_response_code(404);
    $page = 'dashboard';
}

try {
    $taskController = new TaskController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($page !== 'add-task') {
            http_response_code(405);
            exit('Method not allowed');
        }

        try {
            $taskController->store($_POST);
            header('Location: ' . $_SERVER['PHP_SELF'] . '?page=tasks&created=1');
            exit;
        } catch (InvalidArgumentException $exception) {
            $errorMessage = $exception->getMessage();
        }
    }

    $tasks = $taskController->index();
    require $pages[$page];

} catch (PDOException $exception) {
    http_response_code(500);
    echo 'Database connection failed';
}