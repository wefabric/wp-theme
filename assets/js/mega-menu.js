/**
 * Mega menu — open on nav item hover, close when leaving the entire nav bar.
 *
 * Keeps the panel open during diagonal mouse movements by listening to
 * mouseleave on the nav bar as a whole rather than individual items.
 */
document.addEventListener('DOMContentLoaded', () => {
    const navBar = document.querySelector('.main-navigation-bar');
    if (!navBar) return;

    const megaItems    = navBar.querySelectorAll('.main-navigation .menu > li.has-mega-menu');
    const regularItems = navBar.querySelectorAll('.main-navigation .menu > li.menu-item-has-children:not(.has-mega-menu)');
    if (!megaItems.length) return;

    let closeTimer = null;

    function closeAll() {
        megaItems.forEach(i => i.classList.remove('mega-open'));
        regularItems.forEach(i => i.classList.remove('submenu-open'));
    }

    function scheduleClose() {
        clearTimeout(closeTimer);
        closeTimer = setTimeout(closeAll, 100);
    }

    megaItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            closeAll();
            item.classList.add('mega-open');
        });
    });

    regularItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            closeAll();
            item.classList.add('submenu-open');
        });
    });

    const plainItems = navBar.querySelectorAll('.main-navigation .menu > li:not(.menu-item-has-children):not(.has-mega-menu)');
    plainItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            closeAll();
        });
    });

    navBar.addEventListener('mouseleave', scheduleClose);
    navBar.addEventListener('mouseenter', () => clearTimeout(closeTimer));
});
