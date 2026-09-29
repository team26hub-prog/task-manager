<?php
$tasks = $tasks ?? [];
$totalTasks = count($tasks);
$statusCounts = ['pending' => 0, 'in_progress' => 0, 'completed' => 0];
$priorityCounts = ['low' => 0, 'medium' => 0, 'high' => 0];
$employeeReports = [];
$overdueTasks = 0;
$today = date('Y-m-d');

foreach ($tasks as $task) {
    $status = strtolower((string) ($task['status'] ?? ''));
    $priority = strtolower((string) ($task['priority'] ?? ''));
    if (isset($statusCounts[$status])) {
        $statusCounts[$status]++;
    }
    if (isset($priorityCounts[$priority])) {
        $priorityCounts[$priority]++;
    }

    $employeeName = (string) ($task['employee_name'] ?? 'Unassigned');
    if (!isset($employeeReports[$employeeName])) {
        $employeeReports[$employeeName] = ['total' => 0, 'in_progress' => 0, 'completed' => 0];
    }
    $employeeReports[$employeeName]['total']++;
    if ($status === 'in_progress') {
        $employeeReports[$employeeName]['in_progress']++;
    } elseif ($status === 'completed') {
        $employeeReports[$employeeName]['completed']++;
    }
    $dueDate = (string) ($task['due_date'] ?? '');
    if ($dueDate !== '' && $dueDate < $today && $status !== 'completed') {
        $overdueTasks++;
    }
}

$completedTasks = $statusCounts['completed'];
$completionRate = $totalTasks > 0 ? (int) round(($completedTasks / $totalTasks) * 100) : 0;
$pageTitle = 'Reports';
$currentPage = 'reports';
require __DIR__ . '/../layouts/header.php';
?>
<div class="mb-4">
    <div class="eyebrow mb-2">INSIGHTS</div>
    <h1 class="h2 fw-bold mb-1">Reports</h1>
    <p class="text-secondary mb-0">A summary of task status, priority, and due dates.</p>
</div>

<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div class="summary-item p-3 p-lg-4">
            <div class="small text-secondary">Total tasks</div>
            <div class="h3 fw-bold mb-0"><?php echo $totalTasks; ?></div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="summary-item p-3 p-lg-4">
            <div class="small text-secondary">Completion rate</div>
            <div class="h3 fw-bold text-primary mb-0"><?php echo $completionRate; ?>%</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="summary-item p-3 p-lg-4">
            <div class="small text-secondary">Overdue and unfinished</div>
            <div class="h3 fw-bold <?php echo $overdueTasks > 0 ? 'text-danger' : ''; ?> mb-0"><?php echo $overdueTasks; ?></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12 col-lg-6">
        <section class="summary-item p-3 p-lg-4" aria-labelledby="report-status-title">
            <h2 id="report-status-title" class="h6 fw-bold mb-4">Tasks by status</h2>
            <?php foreach (['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed'] as $statusKey => $statusLabel): ?>
                <?php $percentage = $totalTasks > 0 ? (int) round(($statusCounts[$statusKey] / $totalTasks) * 100) : 0; ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between small mb-1"><span class="text-secondary"><?php echo $statusLabel; ?></span><span class="fw-semibold"><?php echo $statusCounts[$statusKey]; ?></span></div>
                    <div class="progress" role="progressbar" aria-label="<?php echo $statusLabel; ?> tasks" aria-valuenow="<?php echo $percentage; ?>" aria-valuemin="0" aria-valuemax="100" style="height: 8px;">
                        <div class="progress-bar <?php echo $statusKey === 'completed' ? 'bg-success' : ($statusKey === 'pending' ? 'bg-warning' : ''); ?>" style="width: <?php echo $percentage; ?>%"></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <div class="col-12 col-lg-6">
        <section class="summary-item p-3 p-lg-4" aria-labelledby="report-priority-title">
            <h2 id="report-priority-title" class="h6 fw-bold mb-4">Tasks by priority</h2>
            <div class="d-grid gap-3">
                <?php foreach (['high' => 'High', 'medium' => 'Medium', 'low' => 'Low'] as $priorityKey => $priorityLabel): ?>
                    <div class="d-flex justify-content-between align-items-center rounded border p-3">
                        <span class="priority-badge priority-<?php echo $priorityKey; ?>"><?php echo $priorityLabel; ?></span>
                        <span class="h5 fw-bold mb-0"><?php echo $priorityCounts[$priorityKey]; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
</div>

<section class="summary-item overflow-hidden mt-3" aria-labelledby="employee-report-title">
    <div class="border-bottom px-3 px-lg-4 py-3">
        <h2 id="employee-report-title" class="h6 fw-bold mb-1">Progress by employee</h2>
        <p class="small text-secondary mb-0">Assigned task completion across the team</p>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th class="ps-3 ps-lg-4">Employee</th><th>Total tasks</th><th>In progress</th><th class="pe-3 pe-lg-4">Completed</th></tr>
            </thead>
            <tbody>
                <?php if (empty($employeeReports)): ?>
                    <tr><td colspan="4" class="py-5 text-center text-secondary">No assigned tasks to report.</td></tr>
                <?php else: ?>
                    <?php foreach ($employeeReports as $employeeName => $counts): ?>
                        <tr>
                            <td class="ps-3 ps-lg-4 fw-semibold text-dark"><?php echo htmlspecialchars($employeeName, ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo $counts['total']; ?></td>
                            <td><?php echo $counts['in_progress']; ?></td>
                            <td class="pe-3 pe-lg-4"><?php echo $counts['completed']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
