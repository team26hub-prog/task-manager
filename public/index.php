<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/TaskController.php';
require_once __DIR__ . '/../app/controllers/EmployeeController.php';

$pages = [
    'setup-admin' => __DIR__ . '/../app/views/auth/setup.php',
    'login' => __DIR__ . '/../app/views/auth/login.php',
    'dashboard' => __DIR__ . '/../app/views/dashboard/index.php',
    'tasks' => __DIR__ . '/../app/views/tasks/index.php',
    'add-task' => __DIR__ . '/../app/views/tasks/create.php',
    'employees' => __DIR__ . '/../app/views/employees/index.php',
    'add-employee' => __DIR__ . '/../app/views/employees/create.php',
    'reports' => __DIR__ . '/../app/views/reports/index.php',
    'settings' => __DIR__ . '/../app/views/settings/index.php',
];
$page = (string) ($_GET['page'] ?? 'dashboard');

if (!isset($pages[$page]) && $page !== 'logout') {
    http_response_code(404);
    $page = 'dashboard';
}

try {
    $authController = new AuthController();
    $hasAdmin = $authController->hasAdmin();

    if (!$hasAdmin && $page !== 'setup-admin') {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=setup-admin');
        exit;
    }

    if ($hasAdmin && $page === 'setup-admin') {
        header('Location: ' . $_SERVER['PHP_SELF'] . (isset($_SESSION['admin_id']) ? '?page=dashboard' : '?page=login'));
        exit;
    }

    if ($page === 'logout') {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
            http_response_code(405);
            exit('Invalid logout request.');
        }

        unset($_SESSION['admin_id'], $_SESSION['admin_name']);
        session_regenerate_id(true);
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=login');
        exit;
    }

    if (!in_array($page, ['setup-admin', 'login'], true) && !isset($_SESSION['admin_id'])) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=login');
        exit;
    }

    if ($page === 'login' && isset($_SESSION['admin_id'])) {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?page=dashboard');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            if (!hash_equals($_SESSION['csrf_token'], (string) ($_POST['csrf_token'] ?? ''))) {
                throw new InvalidArgumentException('The form expired. Reload the page and try again.');
            }

            if ($page === 'setup-admin') {
                $admin = $authController->createFirstAdmin($_POST);
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=dashboard');
                exit;
            }

            if ($page === 'login') {
                $admin = $authController->login($_POST);
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=dashboard');
                exit;
            }

            $taskController = new TaskController();
            $employeeController = new EmployeeController();

            if ($page === 'add-task') {
                $taskController->store($_POST);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=tasks&created=1');
                exit;
            }

            if ($page === 'add-employee') {
                $employeeController->store($_POST);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=employees&created=1');
                exit;
            }

            if ($page === 'tasks' && ($_POST['action'] ?? '') === 'update-status') {
                $taskController->updateStatus($_POST);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=tasks&updated=1');
                exit;
            }

            if ($page === 'tasks' && ($_POST['action'] ?? '') === 'assign-employee') {
                $taskController->assignEmployee($_POST);
                header('Location: ' . $_SERVER['PHP_SELF'] . '?page=tasks&assigned=1');
                exit;
            }

            http_response_code(405);
            exit('Method not allowed');
        } catch (InvalidArgumentException $exception) {
            $errorMessage = $exception->getMessage();
        }
    }

    $csrfToken = $_SESSION['csrf_token'];
    $adminName = (string) ($_SESSION['admin_name'] ?? 'Administrator');

    if (in_array($page, ['setup-admin', 'login'], true)) {
        require $pages[$page];
        exit;
    }

    $taskController = new TaskController();
    $employeeController = new EmployeeController();
    $tasks = in_array($page, ['dashboard', 'tasks', 'reports'], true) ? $taskController->index() : [];
    $employees = in_array($page, ['dashboard', 'tasks', 'add-task', 'employees', 'add-employee'], true)
        ? $employeeController->index()
        : [];
    require $pages[$page];
} catch (PDOException $exception) {
    http_response_code(500);
    echo 'Database connection failed';
}
