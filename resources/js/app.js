document.addEventListener('click', (event) => {
    const menu = document.querySelector('[data-site-mobile-menu]');

    if (!menu) {
        return;
    }

    if (event.target.closest('[data-site-mobile-toggle]')) {
        menu.classList.toggle('hidden');

        return;
    }

    if (event.target.closest('[data-site-mobile-menu] a')) {
        menu.classList.add('hidden');
    }
});