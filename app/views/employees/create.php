<?php
$pageTitle = 'Add Employee';
$currentPage = 'employees';
require __DIR__ . '/../layouts/header.php';
?>
<div class="mb-4">
    <div class="eyebrow mb-2">ADMINISTRATION</div>
    <h1 class="h2 fw-bold mb-1">Add Employee</h1>
    <p class="text-secondary mb-0">Add an employee to assign and track tasks.</p>
</div>

<section class="summary-item p-3 p-lg-4" aria-labelledby="employee-details-title">
    <h2 id="employee-details-title" class="h5 fw-bold mb-4">Employee details</h2>
    <?php if (!empty($errorMessage)): ?>
        <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=add-employee">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
        <div class="row g-3">
            <div class="col-12 col-md-6">
                <label for="employeeName" class="form-label">Full name</label>
                <input id="employeeName" name="name" class="form-control" type="text" maxlength="150" required>
            </div>
            <div class="col-12 col-md-6">
                <label for="employeeEmail" class="form-label">Email</label>
                <input id="employeeEmail" name="email" class="form-control" type="email" maxlength="190" required>
            </div>
            <div class="col-12 col-md-6">
                <label for="employeeDepartment" class="form-label">Department</label>
                <input id="employeeDepartment" name="department" class="form-control" type="text" maxlength="120">
            </div>
            <div class="col-12 d-flex flex-wrap gap-2 pt-2">
                <button type="submit" class="btn btn-primary px-4">Save employee</button>
                <a class="btn btn-light" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=employees">Cancel</a>
            </div>
        </div>
    </form>
</section>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
