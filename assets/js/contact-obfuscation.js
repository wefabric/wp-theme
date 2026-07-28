document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-obfuscated]').forEach((el) => {
        const encoded = el.getAttribute('data-obfuscated');
        const type = el.getAttribute('data-type') || 'email';

        if (!encoded) {
            return;
        }

        const decoded = atob(encoded);

        let href;
        switch (type) {
            case 'tel':
                href = 'tel:' + decoded;
                break;
            case 'whatsapp':
                href = 'https://wa.me/' + decoded.replace(/[^0-9+]/g, '');
                break;
            case 'email':
            default:
                href = 'mailto:' + decoded;
                break;
        }

        el.setAttribute('href', href);
    });
});
