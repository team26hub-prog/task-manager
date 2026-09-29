<?php
$tasks = $tasks ?? [];
$employees = $employees ?? [];
$totalTasks = count($tasks);
$pendingTasks = 0;
$inProgressTasks = 0;
$completedTasks = 0;

foreach ($tasks as $task) {
    if ($task['status'] === 'pending') {
        $pendingTasks++;
    } elseif ($task['status'] === 'in_progress') {
        $inProgressTasks++;
    } elseif ($task['status'] === 'completed') {
        $completedTasks++;
    }
}

$pageTitle = 'Dashboard';
$currentPage = 'dashboard';
require __DIR__ . '/../layouts/header.php';
?>
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <div class="eyebrow mb-2">ADMIN OVERVIEW</div>
        <h1 class="h2 fw-bold mb-1">Dashboard</h1>
        <p class="text-secondary mb-0">Manage employees and monitor assigned task progress.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a class="btn btn-outline-primary px-3" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-employee">
            <i class="bi bi-person-plus me-1" aria-hidden="true"></i> Add Employee
        </a>
        <a class="btn btn-primary px-3" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-task">
            <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Assign Task
        </a>
    </div>
</div>

<section class="row g-3 mb-4" aria-label="Task summary">
    <?php foreach ([['Employees', count($employees), 'bi-people', 'primary'], ['Total tasks', $totalTasks, 'bi-clipboard-check', 'primary'], ['Pending', $pendingTasks, 'bi-hourglass-split', 'warning'], ['In progress', $inProgressTasks, 'bi-arrow-repeat', 'primary'], ['Completed', $completedTasks, 'bi-check2-circle', 'success']] as [$label, $count, $icon, $color]): ?>
        <div class="col-12 col-sm-6 col-xl">
            <div class="summary-item d-flex align-items-center gap-3 p-3 p-lg-4">
                <span class="summary-icon bg-<?php echo $color; ?>-subtle text-<?php echo $color; ?>"><i class="bi <?php echo $icon; ?>" aria-hidden="true"></i></span>
                <div><div class="small text-secondary"><?php echo $label; ?></div><div class="h4 fw-bold mb-0"><?php echo $count; ?></div></div>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<section class="summary-item overflow-hidden" aria-labelledby="recent-tasks-title">
    <div class="d-flex align-items-center justify-content-between gap-3 border-bottom px-3 px-lg-4 py-3">
        <div>
            <h2 id="recent-tasks-title" class="h6 fw-bold mb-1">Recent tasks</h2>
            <p class="small text-secondary mb-0">Latest items added to the task list</p>
        </div>
                    <div class="d-flex gap-3">
                        <a class="small fw-semibold text-decoration-none" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=employees">Employees</a>
                        <a class="small fw-semibold text-decoration-none" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=tasks">View all tasks</a>
                    </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light"><tr><th class="ps-3 ps-lg-4">Title</th><th>Employee</th><th>Status</th><th>Priority</th><th class="pe-3 pe-lg-4">Due Date</th></tr></thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr><td colspan="5" class="py-5 text-center text-secondary">No tasks found</td></tr>
                <?php else: ?>
                    <?php foreach (array_slice($tasks, 0, 5) as $task): ?>
                        <?php
                        $status = strtolower((string) $task['status']);
                        $priority = strtolower((string) $task['priority']);
                        ?>
                        <tr>
                            <td class="ps-3 ps-lg-4 fw-semibold text-dark"><?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($task['employee_name'] ?? 'Unassigned'), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><span class="status-badge status-<?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $status)), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td><span class="priority-badge priority-<?php echo htmlspecialchars($priority, ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars(ucfirst($priority), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td class="pe-3 pe-lg-4 text-nowrap"><?php echo htmlspecialchars((string) ($task['due_date'] ?? 'Not set'), ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
