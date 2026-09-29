<?php
$employees = $employees ?? [];
$pageTitle = 'Employees';
$currentPage = 'employees';
require __DIR__ . '/../layouts/header.php';
?>
<div class="d-flex flex-wrap align-items-end justify-content-between gap-3 mb-4">
    <div>
        <div class="eyebrow mb-2">ADMINISTRATION</div>
        <h1 class="h2 fw-bold mb-1">Employees</h1>
        <p class="text-secondary mb-0">Manage employee records and review assigned work.</p>
    </div>
    <a class="btn btn-primary px-3" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-employee">
        <i class="bi bi-person-plus me-1" aria-hidden="true"></i> Add Employee
    </a>
</div>

<?php if (isset($_GET['created'])): ?>
    <div class="alert alert-success" role="status">Employee added successfully.</div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
<?php endif; ?>

<section class="summary-item overflow-hidden" aria-labelledby="employee-list-title">
    <div class="d-flex align-items-center justify-content-between gap-3 border-bottom px-3 px-lg-4 py-3">
        <div>
            <h2 id="employee-list-title" class="h6 fw-bold mb-1">Employee directory</h2>
            <p class="small text-secondary mb-0">Employee records and assigned task progress</p>
        </div>
        <span class="badge rounded-pill text-bg-light"><?php echo count($employees); ?> total</span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-3 ps-lg-4">Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Tasks</th>
                    <th class="pe-3 pe-lg-4">Completed</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($employees)): ?>
                    <tr><td colspan="5" class="py-5 text-center text-secondary">No employees yet. Add an employee to start assigning tasks.</td></tr>
                <?php else: ?>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td class="ps-3 ps-lg-4 fw-semibold text-dark"><?php echo htmlspecialchars($employee['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($employee['email'] ?? 'Not provided'), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars((string) ($employee['department'] ?? 'Not set'), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo (int) $employee['task_count']; ?></td>
                            <td class="pe-3 pe-lg-4"><?php echo (int) $employee['completed_count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
