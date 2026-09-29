\<?php

$pageUrl = htmlspecialchars($\_SERVER['PHP_SELF'] ?? '/index.php', ENT_QUOTES, 'UTF-8');

$pageTitle = $pageTitle ?? 'Task Manager';

$currentPage = $currentPage ?? 'dashboard';

$adminName = $adminName ?? 'Administrator';

$csrfToken = $csrfToken ?? '';

?>

\<!DOCTYPE html>

\<html lang="en">

\<head>

    \<meta charset="UTF-8">

    \<meta name="viewport" content="width=device-width, initial-scale=1.0">

    \<title>\<?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?> | Task Manager\</title>

    \<link href="https\://cdn.jsdelivr.net/npm/bootstrap\@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    \<link rel="stylesheet" href="https\://cdn.jsdelivr.net/npm/bootstrap-icons\@1.11.3/font/bootstrap-icons.min.css">

    \<style>

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

            position: fixed;

            z-index: 1050;

            inset: 0 auto 0 0;

            width: 300px;

            min-height: 100vh;

            min-height: 100dvh;

            overflow-y: auto;

            flex: 0 0 300px;

            border-right: 1px solid var(--line);

            background: #fff;

            color: var(--ink);

            transform: translateX(-105%);

            transition: transform .28s cubic-bezier(.22, .68, 0, 1);

            box-shadow: 18px 0 48px rgb(23 37 59 / 14%);

        }

        .sidebar.is-open { transform: translateX(0); }

        .sidebar-brand-row {

            margin-bottom: 30px !important;

            padding: 0 2px 20px;

            border-bottom: 1px solid var(--line);

        }

        .sidebar .sidebar-brand-row > a {

            color: var(--ink) !important;

            font-size: 1.02rem;

        }

        .brand-mark {

            display: grid;

            width: 40px;

            height: 40px;

            place-items: center;

            border-radius: 11px;

            background: #3979ef;

            color: #fff;

        }

        .sidebar .nav-link {

            display: flex;

            align-items: center;

            gap: 14px;

            width: 100%;

            min-height: 50px;

            padding: 12px 14px;

            border: 0;

            border-radius: 9px;

            background: transparent;

            color: #526174;

            font-size: .94rem;

            font-weight: 600;

            text-align: left;

            text-decoration: none;

            transition: background-color .16s ease, color .16s ease, transform .16s ease;

        }

        .sidebar .nav-link i {

            display: inline-grid;

            width: 22px;

            flex: 0 0 22px;

            place-items: center;

            color: #7b899b;

            font-size: 1.1rem;

        }

        .sidebar .nav-link:hover {

            background: #f2f5fa;

            color: var(--ink);

        }

        .sidebar .nav-link.active {

            background: #eaf1ff;

            color: #2458b8;

            box-shadow: inset 3px 0 #2864dc;

        }

        .sidebar .nav-link.active i { color: #2864dc; }

        .sidebar .nav-link:focus-visible,

        .mobile-nav-toggle:focus-visible,

        .mobile-drawer-close:focus-visible {

            outline: 3px solid #6d9df4;

            outline-offset: 2px;

        }

        .sidebar .nav { gap: 5px !important; }

        .sidebar-label {

            color: #8793a3;

            font-size: .72rem;

            font-weight: 700;

            letter-spacing: 0;

            text-transform: uppercase;

        }

        .sidebar-footer { border-color: var(--line) !important; }

        .sidebar-account-icon {

            display: grid;

            width: 40px;

            height: 40px;

            flex: 0 0 40px;

            place-items: center;

            border-radius: 50%;

            background: #edf2fa;

            color: #53657d;

            font-size: 1.1rem;

        }

        .sidebar-account-name {

            overflow: hidden;

            color: var(--ink);

            font-size: .88rem;

            font-weight: 700;

            text-overflow: ellipsis;

            white-space: nowrap;

        }

        .sidebar-account-role { color: var(--muted); font-size: .76rem; }

        .sidebar-logout .btn {

            min-height: 42px;

            border-color: var(--line);

            color: #526174;

            font-weight: 600;

        }

        .sidebar-logout .btn:hover {

            border-color: #f2d2d0;

            background: #fff3f2;

            color: #a43b34;

        }

        .main-content { min-width: 0; flex: 1; }

        .drawer-backdrop {

            position: fixed;

            z-index: 1040;

            inset: 0;

            display: block;

            width: 100%;

            height: 100%;

            padding: 0;

            border: 0;

            background: rgb(18 31 49 / 40%);

            backdrop-filter: blur(2px);

        }

        .drawer-backdrop[hidden] { display: none; }

        .topbar {

            min-height: 74px;

            border-bottom: 1px solid var(--line);

            background: #fff;

        }

        .mobile-brand { display: none; }

        .mobile-nav-toggle,

        .mobile-drawer-close {

            display: inline-grid;

            width: 44px;

            height: 44px;

            place-items: center;

            border: 1px solid var(--line);

            border-radius: 9px;

            background: #f7f9fc;

            color: #34445b;

            font-size: 1.25rem;

            transition: background-color .16s ease, border-color .16s ease;

        }

        .mobile-nav-toggle:hover,

        .mobile-drawer-close:hover {

            border-color: #d3dce8;

            background: #edf2f8;

        }

        .mobile-drawer-close {

            width: 38px;

            height: 38px;

            font-size: 1.05rem;

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



        @media (max-width: 768px) {

            body { overflow-x: hidden; }

            .app-shell { display: block !important; }

            .sidebar {

                width: min(320px, calc(100vw - 48px));

            }

            .sidebar .nav { display: flex !important; flex-direction: column; }

            .sidebar .nav-link i {

                display: inline-grid;

                width: 22px;

                place-items: center;

                font-size: 1.1rem;

            }

            .sidebar .sidebar-footer { display: block; }

            .main-content { width: 100%; }

            .topbar {

                min-height: 60px;

                padding: 10px 14px !important;

            }

            .topbar > .eyebrow,

            .topbar > div:not(.mobile-brand) { display: none !important; }

            .mobile-brand { display: flex; align-items: center; gap: 9px; }

            .mobile-brand .brand-mark { width: 34px; height: 34px; }

            .mobile-brand-title { font-size: 1rem; font-weight: 700; }

            .content-wrap { padding: 20px 14px 28px !important; }

            .content-wrap h1.h2 { font-size: 1.4rem; }

            .content-wrap > .d-flex.align-items-end > .btn { width: 100%; min-height: 44px; }

            .content-wrap > .d-flex.align-items-end > .d-flex { width: 100%; }

            .content-wrap > .d-flex.align-items-end > .d-flex .btn { flex: 1 1 0; min-height: 44px; }

            .content-wrap .row > [class\*="col-"] { flex: 0 0 100%; max-width: 100%; }

            .summary-item { min-width: 0; }

            .summary-item.p-3,

            .summary-item.p-3.p-lg-4 { padding: 16px !important; }

            .table-responsive { width: 100%; max-width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }

            .table-responsive > .table { min-width: 100%; width: 100%; }

            .table-responsive .form-select { min-width: 120px; }

            .table-responsive .btn { min-width: 40px; min-height: 38px; }

            .form-control,

            .form-select { min-height: 44px; }

            textarea.form-control { min-height: 110px; }

            .content-wrap p { line-height: 1.45; }

        }



        @media (max-width: 380px) {

            .content-wrap { padding-right: 12px !important; padding-left: 12px !important; }

            .content-wrap > .d-flex.align-items-end > .d-flex { flex-direction: column; }

            .content-wrap > .d-flex.align-items-end > .d-flex .btn { width: 100%; }

            .summary-item.p-3,

            .summary-item.p-3.p-lg-4 { padding: 14px !important; }

        }

    \</style>

\</head>

\<body>

    \<div class="app-shell d-flex">

        \<aside id="appSidebar" class="sidebar d-flex flex-column p-3 p-lg-4">

            \<div class="sidebar-brand-row d-flex align-items-center justify-content-between mb-5">

                \<a class="d-flex align-items-center gap-2 text-decoration-none text-white" href="\<?php echo $pageUrl; ?>?page=dashboard">

                    \<span class="brand-mark">\<i class="bi bi-check2-square" aria-hidden="true">\</i>\</span>

                    \<span class="fw-semibold">Task Manager\</span>

                \</a>

                \<button class="mobile-drawer-close" type="button" aria-label="Close navigation" title="Close menu">

                    \<i class="bi bi-x-lg" aria-hidden="true">\</i>

                \</button>

            \</div>



            \<div class="sidebar-label mb-2 px-2">Workspace\</div>

            \<nav class="nav flex-column gap-1" aria-label="Dashboard navigation">

                \<a class="nav-link \<?php echo $currentPage === 'dashboard' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=dashboard" \<?php echo $currentPage === 'dashboard' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-grid" aria-hidden="true">\</i>\<span>Dashboard\</span>

                \</a>

                \<a class="nav-link \<?php echo $currentPage === 'tasks' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=tasks" \<?php echo $currentPage === 'tasks' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-list-task" aria-hidden="true">\</i>\<span>Tasks\</span>

                \</a>

                \<a class="nav-link \<?php echo $currentPage === 'employees' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=employees" \<?php echo $currentPage === 'employees' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-people" aria-hidden="true">\</i>\<span>Employees\</span>

                \</a>

                \<a class="nav-link \<?php echo $currentPage === 'add-task' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=add-task" \<?php echo $currentPage === 'add-task' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-plus-circle" aria-hidden="true">\</i>\<span>Add Task\</span>

                \</a>

                \<a class="nav-link \<?php echo $currentPage === 'reports' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=reports" \<?php echo $currentPage === 'reports' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-bar-chart-line" aria-hidden="true">\</i>\<span>Reports\</span>

                \</a>

                \<a class="nav-link \<?php echo $currentPage === 'settings' ? 'active' : ''; ?>" href="\<?php echo $pageUrl; ?>?page=settings" \<?php echo $currentPage === 'settings' ? 'aria-current="page"' : ''; ?>>

                    \<i class="bi bi-gear" aria-hidden="true">\</i>\<span>Settings\</span>

                \</a>

            \</nav>



            \<div class="sidebar-footer mt-auto pt-4 border-top">

                \<div class="d-flex align-items-center gap-3">

                    \<span class="sidebar-account-icon">\<i class="bi bi-person-fill" aria-hidden="true">\</i>\</span>

                    \<div class="min-w-0">

                        \<div class="sidebar-account-name">\<?php echo htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?>\</div>

                        \<div class="sidebar-account-role">Administrator\</div>

                    \</div>

                \</div>

                \<form method="post" action="\<?php echo $pageUrl; ?>?page=logout" class="sidebar-logout mt-3">

                    \<input type="hidden" name="csrf_token" value="\<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">

                    \<button class="btn btn-sm btn-outline-secondary w-100" type="submit">\<i class="bi bi-box-arrow-right me-2" aria-hidden="true">\</i>Log out\</button>

                \</form>

            \</div>

        \</aside>

        \<button class="drawer-backdrop" type="button" aria-label="Close navigation" hidden>\</button>



        \<div class="main-content">

            \<header class="topbar d-flex align-items-center justify-content-between px-4 px-xl-5">

                \<div class="mobile-brand" aria-label="Task Manager">

                    \<span class="brand-mark">\<i class="bi bi-check2-square" aria-hidden="true">\</i>\</span>

                    \<span class="mobile-brand-title">Task Manager\</span>

                \</div>

                \<button class="mobile-nav-toggle" type="button" aria-label="Open navigation" aria-controls="appSidebar" aria-expanded="false">

                    \<i class="bi bi-list" aria-hidden="true">\</i>

                \</button>

                \<span class="eyebrow">ADMIN DASHBOARD\</span>

                \<div class="d-flex align-items-center gap-3">

                    \<span class="small text-secondary">\<?php echo htmlspecialchars($adminName, ENT_QUOTES, 'UTF-8'); ?>\</span>

                \</div>

            \</header>

            \<main class="content-wrap container-fluid px-4 px-xl-5 py-4 py-lg-5">
