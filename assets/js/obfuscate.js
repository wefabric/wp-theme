document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-obfuscated-email]').forEach(function (el) {
        const email = atob(el.getAttribute('data-obfuscated-email'));
        el.href = 'mailto:' + email;
    });

    document.querySelectorAll('[data-obfuscated-phone]').forEach(function (el) {
        const phone = atob(el.getAttribute('data-obfuscated-phone'));
        el.href = 'tel:' + phone;
    });

    document.querySelectorAll('[data-obfuscated-whatsapp]').forEach(function (el) {
        const whatsapp = atob(el.getAttribute('data-obfuscated-whatsapp'));
        el.href = 'https://wa.me/' + whatsapp;
    });
});
