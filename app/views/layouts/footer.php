            </main>
        </div>
    </div>
    <script>
        const sidebar = document.getElementById('appSidebar');
        const navToggle = document.querySelector('.mobile-nav-toggle');
        const drawerBackdrop = document.querySelector('.drawer-backdrop');
        const mobileNav = window.matchMedia('(max-width: 768px)');

        function setDrawerOpen(isOpen) {
            if (!sidebar || !navToggle || !drawerBackdrop) return;
            const shouldOpen = mobileNav.matches && isOpen;
            sidebar.classList.toggle('is-open', shouldOpen);
            sidebar.inert = mobileNav.matches && !shouldOpen;
            sidebar.setAttribute('aria-hidden', mobileNav.matches && !shouldOpen ? 'true' : 'false');
            drawerBackdrop.hidden = !shouldOpen;
            navToggle.setAttribute('aria-expanded', String(shouldOpen));
            navToggle.setAttribute('aria-label', shouldOpen ? 'Close navigation' : 'Open navigation');
            navToggle.querySelector('i').className = shouldOpen ? 'bi bi-x-lg' : 'bi bi-list';
            document.body.style.overflow = shouldOpen ? 'hidden' : '';
        }

        if (sidebar && navToggle && drawerBackdrop) {
            setDrawerOpen(false);
            navToggle.addEventListener('click', () => setDrawerOpen(!sidebar.classList.contains('is-open')));
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
