<?php
$tasks = $tasks ?? [];
$pageTitle = 'Tasks';
$currentPage = 'tasks';
require __DIR__ . '/../layouts/header.php';
?>
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <div class="eyebrow mb-2">TASK MANAGEMENT</div>
        <h1 class="h2 fw-bold mb-1">Tasks</h1>
        <p class="text-secondary mb-0">Review and track your team's tasks.</p>
    </div>
    <a class="btn btn-primary px-3" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-task">
        <i class="bi bi-plus-lg me-1" aria-hidden="true"></i> Add Task
    </a>
</div>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success" role="status">Task added successfully.</div>
<?php endif; ?>

<section class="summary-item overflow-hidden tasks-list" aria-labelledby="task-list-title">
    <div class="d-flex align-items-center justify-content-between gap-3 border-bottom px-3 px-lg-4 py-3">
        <div>
            <h2 id="task-list-title" class="h6 fw-bold mb-1">All tasks</h2>
            <p class="small text-secondary mb-0">Tasks saved in your database</p>
        </div>
        <span class="badge rounded-pill text-bg-light"><?php echo count($tasks); ?> total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="ps-3 ps-lg-4">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col" class="pe-3 pe-lg-4">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr class="tasks-empty-row"><td colspan="5" class="py-5 text-center text-secondary">No tasks found</td></tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php
                        $status = strtolower((string) ($task['status'] ?? ''));
                        $priority = strtolower((string) ($task['priority'] ?? ''));
                        $statusClass = in_array($status, ['pending', 'in_progress', 'completed'], true) ? 'status-' . $status : 'status-default';
                        $priorityClass = in_array($priority, ['low', 'medium', 'high'], true) ? 'priority-' . $priority : 'priority-default';
                        ?>
                        <tr>
                            <td class="ps-3 ps-lg-4 fw-semibold text-dark" data-label="Title"><?php echo htmlspecialchars((string) ($task['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td data-label="Description"><?php echo htmlspecialchars((string) ($task['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td data-label="Status"><span class="status-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $status)), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td data-label="Priority"><span class="priority-badge <?php echo $priorityClass; ?>"><?php echo htmlspecialchars(ucfirst($priority), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td class="pe-3 pe-lg-4 text-nowrap" data-label="Due Date"><?php echo htmlspecialchars((string) ($task['due_date'] ?? 'Not set'), ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>