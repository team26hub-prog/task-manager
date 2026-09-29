<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set up admin | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { min-height: 100vh; display: grid; place-items: center; background: #f3f6fb; color: #17253b; font-family: "Segoe UI", sans-serif; }
        .auth-panel { width: min(100% - 32px, 480px); border: 1px solid #e7ecf3; border-radius: 10px; background: #fff; }
        .auth-mark { display: grid; width: 42px; height: 42px; place-items: center; border-radius: 10px; background: #2864dc; color: #fff; font-size: 1.2rem; }
    </style>
</head>
<body>
    <main class="auth-panel p-4 p-md-5 shadow-sm">
        <div class="auth-mark mb-4"><i class="bi bi-shield-lock" aria-hidden="true"></i>A</div>
        <div class="text-uppercase text-secondary small fw-semibold mb-2">Task Manager</div>
        <h1 class="h3 fw-bold mb-2">Create admin account</h1>
        <p class="text-secondary mb-4">Set up the administrator account to manage employees and tasks.</p>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=setup-admin">
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="mb-3">
                <label class="form-label" for="fullName">Full name</label>
                <input class="form-control" id="fullName" name="full_name" type="text" maxlength="150" autocomplete="name" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email" maxlength="190" autocomplete="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input class="form-control" id="password" name="password" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
                    <button class="btn btn-outline-secondary" type="button" data-password-toggle="password" aria-label="Show password" title="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="passwordConfirmation">Confirm password</label>
                <div class="input-group">
                    <input class="form-control" id="passwordConfirmation" name="password_confirmation" type="password" minlength="8" maxlength="255" autocomplete="new-password" required>
                    <button class="btn btn-outline-secondary" type="button" data-password-toggle="passwordConfirmation" aria-label="Show password" title="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Create admin account</button>
        </form>
    </main>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((button) => {
            const passwordInput = document.getElementById(button.dataset.passwordToggle);

            button.addEventListener('click', () => {
                const showPassword = passwordInput.type === 'password';
                passwordInput.type = showPassword ? 'text' : 'password';
                button.querySelector('i').className = showPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
                button.setAttribute('aria-label', showPassword ? 'Hide password' : 'Show password');
                button.title = showPassword ? 'Hide password' : 'Show password';
            });
        });
    </script>
</body>
</html>
