document.addEventListener('DOMContentLoaded', () => {
    const userMenu = document.getElementById('userMenu');
    const userButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenu && userButton && userDropdown) {
        userButton.addEventListener('click', (event) => {
            event.stopPropagation();

            const isOpen = userMenu.classList.toggle('open');

            userButton.setAttribute(
                'aria-expanded',
                isOpen ? 'true' : 'false'
            );
        });

        document.addEventListener('click', (event) => {
            if (!userMenu.contains(event.target)) {
                userMenu.classList.remove('open');
                userButton.setAttribute('aria-expanded', 'false');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                userMenu.classList.remove('open');
                userButton.setAttribute('aria-expanded', 'false');
            }
        });
    }

    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');

    if (sidebar && menuToggle && sidebarBackdrop) {
        const setSidebarOpen = (open) => {
            sidebar.classList.toggle('open', open);
            menuToggle.setAttribute('aria-expanded', String(open));
            menuToggle.setAttribute(
                'aria-label',
                open ? 'Close navigation menu' : 'Open navigation menu'
            );
            sidebarBackdrop.setAttribute('aria-hidden', String(!open));
            document.body.classList.toggle('sidebar-open', open);
        };

        menuToggle.addEventListener('click', () => {
            setSidebarOpen(!sidebar.classList.contains('open'));
        });

        sidebarBackdrop.addEventListener('click', () => setSidebarOpen(false));

        sidebar.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => setSidebarOpen(false));
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && sidebar.classList.contains('open')) {
                setSidebarOpen(false);
                menuToggle.focus();
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 991 && sidebar.classList.contains('open')) {
                setSidebarOpen(false);
            }
        });
    }
});