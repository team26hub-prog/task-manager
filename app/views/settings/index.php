<?php
$pageTitle = 'Settings';
$currentPage = 'settings';
require __DIR__ . '/../layouts/header.php';
?>
<div class="mb-4">
    <div class="eyebrow mb-2">PREFERENCES</div>
    <h1 class="h2 fw-bold mb-1">Settings</h1>
    <p class="text-secondary mb-0">Choose the defaults used when adding a task.</p>
</div>

<form id="settingsForm" class="summary-item p-3 p-lg-4">
    <div class="row g-3 align-items-end">
        <div class="col-12 col-md-5">
            <label for="defaultTaskStatus" class="form-label">Default task status</label>
            <select id="defaultTaskStatus" class="form-select">
                <option value="pending">Pending</option>
                <option value="in_progress">In progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="defaultTaskPriority" class="form-label">Default task priority</label>
            <select id="defaultTaskPriority" class="form-select">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
        </div>
        <div class="col-12 col-md-2 d-grid">
            <button class="btn btn-primary" type="submit">Save settings</button>
        </div>
    </div>
    <div class="d-flex flex-wrap justify-content-between gap-2 mt-3">
        <span class="small text-secondary">Preferences are saved in this browser.</span>
        <span id="settingsSavedMessage" class="small text-success" role="status" aria-live="polite"></span>
    </div>
</form>
<script>
    const settingsForm = document.getElementById('settingsForm');
    const defaultTaskStatus = document.getElementById('defaultTaskStatus');
    const defaultTaskPriority = document.getElementById('defaultTaskPriority');
    const savedSettingsMessage = document.getElementById('settingsSavedMessage');
    const savedSettings = JSON.parse(localStorage.getItem('taskManagerSettings') || '{}');

    defaultTaskStatus.value = savedSettings.status || 'pending';
    defaultTaskPriority.value = savedSettings.priority || 'medium';

    settingsForm.addEventListener('submit', (event) => {
        event.preventDefault();
        localStorage.setItem('taskManagerSettings', JSON.stringify({
            status: defaultTaskStatus.value,
            priority: defaultTaskPriority.value,
        }));
        savedSettingsMessage.textContent = 'Settings saved.';
    });
</script>
<?php require __DIR__ . '/../layouts/footer.php'; ?>
