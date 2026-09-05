document.addEventListener('DOMContentLoaded', () => {
    const toggle = document.querySelector('[data-site-mobile-toggle]');
    const menu = document.querySelector('[data-site-mobile-menu]');

    if (toggle && menu) {
        toggle.addEventListener('click', () => {
            menu.classList.toggle('hidden');
        });
    }
});
