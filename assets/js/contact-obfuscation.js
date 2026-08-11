document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.wf-obfuscated[data-href]').forEach(function (el) {
        el.setAttribute('href', atob(el.dataset.href));
        el.removeAttribute('data-href');

        if (el.dataset.target) {
            el.setAttribute('target', el.dataset.target);
            el.setAttribute('rel', 'noopener noreferrer');
            el.removeAttribute('data-target');
        }
    });
});
