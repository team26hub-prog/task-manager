<?php

require_once __DIR__ . '/../app/controllers/TaskController.php';

$pages = [
    'dashboard' => __DIR__ . '/../app/views/dashboard/index.php',
    'tasks' => __DIR__ . '/../app/views/tasks/index.php',
    'add-task' => __DIR__ . '/../app/views/tasks/create.php',
    'reports' => __DIR__ . '/../app/views/reports/index.php',
    'settings' => __DIR__ . '/../app/views/settings/index.php',
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
