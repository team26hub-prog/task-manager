<?php
$tasks = $tasks ?? [];
$employees = $employees ?? [];
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
<?php if (isset($_GET['updated'])): ?>
    <div class="alert alert-success" role="status">Task status updated.</div>
<?php endif; ?>
<?php if (isset($_GET['assigned'])): ?>
    <div class="alert alert-success" role="status">Task assigned successfully.</div>
<?php endif; ?>
<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<section class="summary-item overflow-hidden" aria-labelledby="task-list-title">
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
                    <th scope="col">Assignee</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Priority</th>
                    <th scope="col" class="pe-3 pe-lg-4">Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($tasks)): ?>
                    <tr><td colspan="6" class="py-5 text-center text-secondary">No tasks found</td></tr>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php
                        $status = strtolower((string) ($task['status'] ?? ''));
                        $priority = strtolower((string) ($task['priority'] ?? ''));
                        $statusClass = in_array($status, ['pending', 'in_progress', 'completed'], true) ? 'status-' . $status : 'status-default';
                        $priorityClass = in_array($priority, ['low', 'medium', 'high'], true) ? 'priority-' . $priority : 'priority-default';
                        ?>
                        <tr>
                            <td class="ps-3 ps-lg-4 fw-semibold text-dark"><?php echo htmlspecialchars((string) ($task['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <div class="d-flex flex-column gap-2">
                                    <span class="small fw-semibold"><?php echo htmlspecialchars((string) ($task['employee_name'] ?? 'Unassigned'), ENT_QUOTES, 'UTF-8'); ?></span>
                                    <?php if (!empty($employees)): ?>
                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=tasks" class="d-flex align-items-center gap-2">
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                            <input type="hidden" name="action" value="assign-employee">
                                            <input type="hidden" name="task_id" value="<?php echo (int) $task['id']; ?>">
                                            <select class="form-select form-select-sm" name="employee_id" aria-label="Assign <?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?> to employee" required>
                                                <option value="">Choose employee</option>
                                                <?php foreach ($employees as $employee): ?>
                                                    <option value="<?php echo (int) $employee['id']; ?>" <?php echo (int) ($task['employee_id'] ?? 0) === (int) $employee['id'] ? 'selected' : ''; ?>><?php echo htmlspecialchars($employee['name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="btn btn-sm btn-outline-primary" type="submit" title="Save assignment" aria-label="Save assignment for <?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                                <i class="bi bi-person-check" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td><?php echo htmlspecialchars((string) ($task['description'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=tasks" class="d-flex align-items-center gap-2">
                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="action" value="update-status">
                                    <input type="hidden" name="task_id" value="<?php echo (int) $task['id']; ?>">
                                    <select class="form-select form-select-sm" name="status" aria-label="Update status for <?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php foreach (['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed'] as $statusValue => $statusLabel): ?>
                                            <option value="<?php echo $statusValue; ?>" <?php echo $status === $statusValue ? 'selected' : ''; ?>><?php echo $statusLabel; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary" type="submit" title="Save status" aria-label="Save status for <?php echo htmlspecialchars((string) $task['title'], ENT_QUOTES, 'UTF-8'); ?>">
                                        <i class="bi bi-check2" aria-hidden="true"></i>
                                    </button>
                                </form>
                            </td>
                            <td><span class="priority-badge <?php echo $priorityClass; ?>"><?php echo htmlspecialchars(ucfirst($priority), ENT_QUOTES, 'UTF-8'); ?></span></td>
                            <td class="pe-3 pe-lg-4 text-nowrap"><?php echo htmlspecialchars((string) ($task['due_date'] ?? 'Not set'), ENT_QUOTES, 'UTF-8'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>