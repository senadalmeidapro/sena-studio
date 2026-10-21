const closeMobileMenu = ({ restoreFocus = false } = {}) => {
    const menu = document.querySelector('[data-site-mobile-menu]');
    const toggle = document.querySelector('[data-site-mobile-toggle]');

    if (!menu || !toggle) return;

    menu.classList.add('hidden');
    menu.setAttribute('aria-hidden', 'true');
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
        menu.setAttribute('aria-hidden', String(isOpen));
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

const initPrivacyConsent = () => {
    const panel = document.querySelector('[data-privacy-consent]');
    const payload = document.querySelector('#analytics-consent-payload');

    if (!panel || !payload) return;

    const storageKey = 'sena-studio.analytics-consent.v1';
    const maxAge = 183 * 24 * 60 * 60 * 1000;
    let choice;

    try {
        choice = JSON.parse(localStorage.getItem(storageKey) ?? 'null');
    } catch {
        choice = null;
    }

    const choiceAge = choice && Number.isFinite(choice.updatedAt) ? Date.now() - choice.updatedAt : -1;
    const valid = choice
        && ['granted', 'denied'].includes(choice.value)
        && choice.provider === panel.dataset.provider
        && choiceAge >= 0
        && choiceAge < maxAge;

    const loadAnalytics = () => {
        if (document.documentElement.dataset.analyticsLoaded === 'true') return;

        const fragment = payload.content.cloneNode(true);
        fragment.querySelectorAll('script').forEach((source) => {
            const script = document.createElement('script');
            [...source.attributes].forEach(({ name, value }) => script.setAttribute(name, value));
            script.textContent = source.textContent;
            source.replaceWith(script);
        });
        document.head.append(fragment);
        document.documentElement.dataset.analyticsLoaded = 'true';
    };

    const showPanel = () => {
        panel.classList.remove('hidden');
    };

    if (valid && choice.value === 'granted') loadAnalytics();
    if (!valid) showPanel();

    if (window.__privacyConsentListenerAttached) return;
    window.__privacyConsentListenerAttached = true;

    document.addEventListener('click', (event) => {
        if (event.target.closest('[data-open-privacy-preferences]')) {
            showPanel();
            return;
        }

        const button = event.target.closest('[data-consent-choice]');
        if (!button || !panel.contains(button)) return;

        const value = button.dataset.consentChoice;
        const analyticsWasLoaded = document.documentElement.dataset.analyticsLoaded === 'true';
        const consentId = crypto.randomUUID();
        const updatedAt = Date.now();
        const savedChoice = {
            value,
            updatedAt,
            provider: panel.dataset.provider,
            consentId,
        };

        try {
            localStorage.setItem(storageKey, JSON.stringify(savedChoice));
        } catch {
            // If storage is unavailable, the choice applies to this page view only.
        }

        const consentReceipt = fetch(panel.dataset.consentEndpoint, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                consent_id: consentId,
                provider: panel.dataset.provider,
                choice: value,
                policy_version: 'v1',
            }),
        }).catch(() => {});

        choice = savedChoice;
        panel.classList.add('hidden');

        if (value === 'granted') loadAnalytics();
        else if (analyticsWasLoaded) {
            Promise.race([consentReceipt, new Promise((resolve) => setTimeout(resolve, 1500))])
                .finally(() => window.location.reload());
        }
    });
};

document.addEventListener('DOMContentLoaded', initPrivacyConsent, { once: true });
document.addEventListener('livewire:navigated', initPrivacyConsent);
document.addEventListener('livewire:navigated', () => closeMobileMenu());
