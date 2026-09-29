            </main>
        </div>
    </div>
    <script>
        const sidebar = document.getElementById('appSidebar');
        const navToggle = document.querySelector('.mobile-nav-toggle');
        const drawerClose = document.querySelector('.mobile-drawer-close');
        const drawerBackdrop = document.querySelector('.drawer-backdrop');
        const mobileNav = window.matchMedia('(max-width: 768px)');

        function setDrawerOpen(isOpen) {
            if (!sidebar || !navToggle || !drawerBackdrop) return;
            const wasOpen = sidebar.classList.contains('is-open');
            const shouldOpen = isOpen;
            sidebar.classList.toggle('is-open', shouldOpen);
            sidebar.inert = !shouldOpen;
            sidebar.setAttribute('aria-hidden', shouldOpen ? 'false' : 'true');
            drawerBackdrop.hidden = !shouldOpen;
            navToggle.setAttribute('aria-expanded', String(shouldOpen));
            navToggle.setAttribute('aria-label', shouldOpen ? 'Close navigation' : 'Open navigation');
            navToggle.querySelector('i').className = shouldOpen ? 'bi bi-x-lg' : 'bi bi-list';
            document.body.style.overflow = shouldOpen ? 'hidden' : '';
            if (shouldOpen) drawerClose?.focus();
            else if (wasOpen) navToggle.focus();
        }

        if (sidebar && navToggle && drawerBackdrop) {
            setDrawerOpen(false);
            navToggle.addEventListener('click', () => setDrawerOpen(!sidebar.classList.contains('is-open')));
            drawerClose?.addEventListener('click', () => setDrawerOpen(false));
            drawerBackdrop.addEventListener('click', () => setDrawerOpen(false));
            sidebar.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setDrawerOpen(false)));
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') setDrawerOpen(false);
            });
            mobileNav.addEventListener('change', () => setDrawerOpen(false));
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
