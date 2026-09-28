<?php
$pageTitle = 'Add Task';
$currentPage = 'add-task';
require __DIR__ . '/../layouts/header.php';
?>
<div class="mb-4">
    <div class="eyebrow mb-2">TASK MANAGEMENT</div>
    <h1 class="h2 fw-bold mb-1">Add Task</h1>
    <p class="text-secondary mb-0">Enter the task details below.</p>
</div>

<section class="summary-item p-3 p-lg-4" aria-labelledby="add-task-title">
    <h2 id="add-task-title" class="h5 fw-bold mb-4">Task details</h2>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-task">
        <div class="row g-3">
            <div class="col-12">
                <label for="taskTitle" class="form-label">Title</label>
                <input id="taskTitle" name="title" class="form-control" type="text" maxlength="255" required>
            </div>
            <div class="col-12">
                <label for="taskDescription" class="form-label">Description</label>
                <textarea id="taskDescription" name="description" class="form-control" rows="4"></textarea>
            </div>
            <div class="col-12 col-md-6">
                <label for="taskStatus" class="form-label">Status</label>
                <select id="taskStatus" name="status" class="form-select">
                    <option value="pending">Pending</option>
                    <option value="in_progress">In progress</option>
                    <option value="completed">Completed</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="taskPriority" class="form-label">Priority</label>
                <select id="taskPriority" name="priority" class="form-select">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label for="taskDueDate" class="form-label">Due date</label>
                <input id="taskDueDate" name="due_date" class="form-control" type="date">
            </div>
            <div class="col-12 d-flex flex-wrap gap-2 pt-2">
                <button type="submit" class="btn btn-primary px-4">Save task</button>
                <a class="btn btn-light" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=tasks">Cancel</a>
            </div>
        </div>
    </form>
</section>
<script>
    const taskDefaults = JSON.parse(localStorage.getItem('taskManagerSettings') || '{}');
    document.getElementById('taskStatus').value = taskDefaults.status || 'pending';
    document.getElementById('taskPriority').value = taskDefaults.priority || 'medium';
</script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
