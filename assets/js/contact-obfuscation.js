(function () {
    const decode = (payload) => {
        const bytes = Uint8Array.from(atob(payload), (character) => character.charCodeAt(0));
        const key = bytes[0];
        const decoded = bytes.slice(1).map((byte, index) => byte ^ ((key + index) % 256));

        return new TextDecoder().decode(decoded);
    };

    const elementsMatching = (root, selector) => {
        const matches = Array.from(root.querySelectorAll(selector));

        return root.matches && root.matches(selector) ? [root, ...matches] : matches;
    };

    const revealText = (element) => {
        element.textContent = decode(element.dataset.wfo);
        element.removeAttribute('data-wfo');
    };

    const protectedAttributes = ['aria-label', 'title', 'alt'];

    const revealAttributes = (element) => {
        protectedAttributes.forEach((attribute) => {
            const payload = element.getAttribute(`data-wfo-${attribute}`);

            if (payload === null) {
                return;
            }

            element.setAttribute(attribute, decode(payload));
            element.removeAttribute(`data-wfo-${attribute}`);
        });
    };

    const contactValue = (href) => decodeURIComponent(href.replace(/^(mailto|tel|sms):/i, '').split('?')[0]);

    // Phone numbers are compared on their last nine digits, so a local number also matches its +31 form.
    const mentionsValue = (text, value) => {
        if (value.includes('@')) {
            return text.toLowerCase().includes(value.toLowerCase());
        }

        return text.replace(/\D/g, '').includes(value.replace(/\D/g, '').slice(-9));
    };

    const revealLink = (link) => {
        const href = decode(link.dataset.wfoHref);

        // Editors can add data-* attributes, so never let a payload smuggle in a javascript: URL.
        if (! /^(mailto|tel|sms|whatsapp|https?):/i.test(href)) {
            throw new Error('Unsupported contact link');
        }

        link.setAttribute('href', href);
        link.removeAttribute('data-wfo-href');

        if (! /^(mailto|tel|sms):/i.test(href)) {
            return;
        }

        // Screen readers should announce the actual address or number, not a generic label like "E-mailadres".
        const value = contactValue(href);
        const label = link.getAttribute('aria-label') || link.getAttribute('title');

        if (label && mentionsValue(label, value)) {
            return;
        }

        if (mentionsValue(link.textContent, value)) {
            link.removeAttribute('aria-label');

            return;
        }

        link.setAttribute('aria-label', label ? `${label}: ${value}` : value);
    };

    const safely = (reveal) => (element) => {
        try {
            reveal(element);
        } catch (error) {
            // A single malformed value must not prevent the other contact details from working.
        }
    };

    const revealAll = (root) => {
        elementsMatching(root, '[data-wfo]').forEach(safely(revealText));
        elementsMatching(root, protectedAttributes.map((attribute) => `[data-wfo-${attribute}]`).join(',')).forEach(safely(revealAttributes));
        elementsMatching(root, '[data-wfo-href]').forEach(safely(revealLink));
    };

    revealAll(document);

    new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === Node.ELEMENT_NODE) {
                    revealAll(node);
                }
            });
        });
    }).observe(document.documentElement, { childList: true, subtree: true });
})();
