<?php
$pageUrl = htmlspecialchars($_SERVER['PHP_SELF'] ?? '/index.php', ENT_QUOTES, 'UTF-8');
$pageTitle = $pageTitle ?? 'Task Manager';
$currentPage = $currentPage ?? 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --ink: #17253b;
            --muted: #718096;
            --blue: #2864dc;
            --navy: #142743;
            --canvas: #f3f6fb;
            --line: #e7ecf3;
        }

        body {
            min-height: 100vh;
            background: var(--canvas);
            color: var(--ink);
            font-family: "Segoe UI", sans-serif;
        }

        .app-shell { min-height: 100vh; }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            flex: 0 0 250px;
            background: var(--navy);
            color: #d4deed;
        }
        .brand-mark {
            display: grid;
            width: 36px;
            height: 36px;
            place-items: center;
            border-radius: 10px;
            background: #3979ef;
            color: #fff;
        }
        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 11px 13px;
            border: 0;
            border-radius: 7px;
            background: transparent;
            color: #c1cde0;
            text-align: left;
            text-decoration: none;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #263d5d;
            color: #fff;
        }
        .sidebar .nav-link.active { box-shadow: inset 3px 0 #6ea0ff; }
        .sidebar-label {
            color: #8292aa;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .main-content { min-width: 0; flex: 1; }
        .topbar {
            min-height: 70px;
            border-bottom: 1px solid var(--line);
            background: #fff;
        }
        .content-wrap { max-width: 1450px; }
        .eyebrow { color: var(--muted); font-size: .78rem; font-weight: 600; }
        .summary-item {
            height: 100%;
            border: 1px solid var(--line);
            border-radius: 8px;
            background: #fff;
        }
        .summary-icon {
            display: grid;
            width: 42px;
            height: 42px;
            place-items: center;
            border-radius: 8px;
            font-size: 1.15rem;
        }
        .table thead th {
            padding-top: 14px;
            padding-bottom: 14px;
            color: #738198;
            font-size: .76rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .table tbody td { padding-top: 16px; padding-bottom: 16px; color: #4b5b70; }
        .status-badge,
        .priority-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .status-pending { background: #fff3d8; color: #946200; }
        .status-in_progress { background: #e6efff; color: #2458b8; }
        .status-completed { background: #e2f5ec; color: #20734c; }
        .status-default { background: #edf0f5; color: #556274; }
        .priority-low { background: #e5f4eb; color: #26754c; }
        .priority-medium { background: #fff3d8; color: #946200; }
        .priority-high { background: #fde8e6; color: #b13a32; }
        .priority-default { background: #edf0f5; color: #556274; }

        @media (max-width: 767.98px) {
            .app-shell { display: block !important; }
            .sidebar { width: 100%; min-height: auto; }
            .sidebar nav { display: grid !important; grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .sidebar .sidebar-footer { display: none; }
            .main-content { width: 100%; }
        }
    </style>
</head>
<body>
    <div class="app-shell d-flex">
        <aside class="sidebar d-flex flex-column p-3 p-lg-4">
            <a class="d-flex align-items-center gap-2 mb-5 text-decoration-none text-white" href="<?php echo $pageUrl; ?>?page=dashboard">
                <span class="brand-mark"><i class="bi bi-check2-square" aria-hidden="true"></i></span>
                <span class="fw-semibold">Task Manager</span>
            </a>

            <div class="sidebar-label mb-2 px-2">Workspace</div>
            <nav class="nav flex-column gap-1" aria-label="Dashboard navigation">
                <a class="nav-link <?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>" href="<?php echo $pageUrl; ?>?page=dashboard" <?php echo $currentPage === 'dashboard' ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-grid" aria-hidden="true"></i><span>Dashboard</span>
                </a>
                <a class="nav-link <?php echo $currentPage === 'tasks' ? 'active' : ''; ?>" href="<?php echo $pageUrl; ?>?page=tasks" <?php echo $currentPage === 'tasks' ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-list-task" aria-hidden="true"></i><span>Tasks</span>
                </a>
                <a class="nav-link <?php echo $currentPage === 'add-task' ? 'active' : ''; ?>" href="<?php echo $pageUrl; ?>?page=add-task" <?php echo $currentPage === 'add-task' ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-plus-circle" aria-hidden="true"></i><span>Add Task</span>
                </a>
                <a class="nav-link <?php echo $currentPage === 'reports' ? 'active' : ''; ?>" href="<?php echo $pageUrl; ?>?page=reports" <?php echo $currentPage === 'reports' ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-bar-chart-line" aria-hidden="true"></i><span>Reports</span>
                </a>
                <a class="nav-link <?php echo $currentPage === 'settings' ? 'active' : ''; ?>" href="<?php echo $pageUrl; ?>?page=settings" <?php echo $currentPage === 'settings' ? 'aria-current="page"' : ''; ?>>
                    <i class="bi bi-gear" aria-hidden="true"></i><span>Settings</span>
                </a>
            </nav>

            <div class="sidebar-footer mt-auto pt-4 border-top border-secondary">
                <div class="small fw-semibold text-white">Employee workspace</div>
                <div class="small text-white-50"><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></div>
            </div>
        </aside>

        <div class="main-content">
            <header class="topbar d-flex align-items-center justify-content-between px-4 px-xl-5">
                <span class="eyebrow">EMPLOYEE WORKSPACE</span>
                <span class="small text-secondary"><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></span>
            </header>
            <main class="content-wrap container-fluid px-4 px-xl-5 py-4 py-lg-5">
