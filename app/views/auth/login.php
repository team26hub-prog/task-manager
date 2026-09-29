<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin login | Task Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { min-height: 100vh; display: grid; place-items: center; background: #f3f6fb; color: #17253b; font-family: "Segoe UI", sans-serif; }
        .auth-panel { width: min(100% - 32px, 440px); border: 1px solid #e7ecf3; border-radius: 10px; background: #fff; }
        .auth-mark { display: grid; width: 42px; height: 42px; place-items: center; border-radius: 10px; background: #2864dc; color: #fff; font-size: 1.2rem; }
    </style>
</head>
<body>
    <main class="auth-panel p-4 p-md-5 shadow-sm">
        <div class="auth-mark mb-4">A</div>
        <div class="text-uppercase text-secondary small fw-semibold mb-2">Task Manager</div>
        <h1 class="h3 fw-bold mb-2">Admin login</h1>
        <p class="text-secondary mb-4">Sign in to manage employees and tasks.</p>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>
        <form id="loginForm" class="needs-validation" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES, 'UTF-8'); ?>?page=login" novalidate>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email" maxlength="190" autocomplete="username" required autofocus>
                <div id="emailFeedback" class="invalid-feedback" aria-live="polite">Please enter a valid email address.</div>
            </div>
            <div class="mb-4">
                <label class="form-label" for="password">Password</label>
                <div class="input-group">
                    <input class="form-control" id="password" name="password" type="password" minlength="8" autocomplete="current-password" required>
                    <button class="btn btn-outline-secondary" type="button" data-password-toggle="password" aria-label="Show password" title="Show password"><i class="bi bi-eye" aria-hidden="true"></i></button>
                </div>
                <div class="invalid-feedback">Enter your password (at least 8 characters).</div>
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
        </form>
    </main>
    <script>
        const loginForm = document.getElementById('loginForm');
        const emailInput = document.getElementById('email');
        const emailFeedback = document.getElementById('emailFeedback');
        const emailFormat = /^[A-Z0-9._%+-]+@(?:[A-Z0-9-]+\.)+(?:com|org|net|edu|gov|mil|int|info|biz|name|pro|aero|asia|cat|coop|jobs|mobi|museum|travel|xyz|online|site|store|tech|app|dev|io|ai|me|tv|co|[A-Z]{2})$/i;

        const validateEmail = () => {
            const value = emailInput.value.trim();
            emailInput.value = value;
            const validEmail = emailFormat.test(value) && value.length <= 190;
            const message = validEmail ? '' : 'Please enter a valid email address.';

            emailInput.setCustomValidity(message);
            emailFeedback.textContent = message || 'Please enter a valid email address.';
            emailInput.classList.toggle('is-invalid', message !== '');
            emailInput.classList.toggle('is-valid', validEmail);
        };

        emailInput.addEventListener('input', validateEmail);

        loginForm.addEventListener('submit', (event) => {
            validateEmail();

            if (!loginForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            loginForm.classList.add('was-validated');
        });

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
