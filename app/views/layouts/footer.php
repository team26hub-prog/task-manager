<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('appSidebar');
    const openBtn = document.querySelector('.mobile-nav-toggle');
    const closeBtn = document.querySelector('.mobile-drawer-close');
    const backdrop = document.querySelector('.drawer-backdrop');

    function openMenu() {
        sidebar.classList.add('is-open');
        backdrop.hidden = false;
        openBtn.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        sidebar.classList.remove('is-open');
        backdrop.hidden = true;
        openBtn.setAttribute('aria-expanded', 'false');
    }

    openBtn?.addEventListener('click', openMenu);
    closeBtn?.addEventListener('click', closeMenu);
    backdrop?.addEventListener('click', closeMenu);

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeMenu();
    });
});
</script>