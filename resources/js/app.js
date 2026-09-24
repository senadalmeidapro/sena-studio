const closeMobileMenu = ({ restoreFocus = false } = {}) => {
    const menu = document.querySelector('[data-site-mobile-menu]');
    const toggle = document.querySelector('[data-site-mobile-toggle]');

    if (!menu || !toggle) return;

    menu.classList.add('hidden');
    toggle.setAttribute('aria-expanded', 'false');

    if (restoreFocus) toggle.focus();
};

document.addEventListener('click', (event) => {
    if (event.target.closest('[data-cv-print]')) {
        window.print();
        return;
    }

    const menu = document.querySelector('[data-site-mobile-menu]');
    const toggle = event.target.closest('[data-site-mobile-toggle]');

    if (!menu) return;

    if (toggle) {
        const isOpen = toggle.getAttribute('aria-expanded') === 'true';
        menu.classList.toggle('hidden', isOpen);
        toggle.setAttribute('aria-expanded', String(!isOpen));
        return;
    }

    if (event.target.closest('[data-site-mobile-menu] a')) {
        closeMobileMenu();
        return;
    }

    if (!menu.classList.contains('hidden') && !menu.contains(event.target)) {
        closeMobileMenu();
    }
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && !document.querySelector('[data-site-mobile-menu]')?.classList.contains('hidden')) {
        closeMobileMenu({ restoreFocus: true });
    }
});

document.addEventListener('livewire:navigated', () => closeMobileMenu());
