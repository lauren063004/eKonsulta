document.addEventListener('DOMContentLoaded', () => {
    const userMenu = document.getElementById('userMenu');
    const userButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (!userMenu || !userButton || !userDropdown) {
        return;
    }

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
});