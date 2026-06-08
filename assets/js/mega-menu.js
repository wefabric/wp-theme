/**
 * Mega menu — open on nav item hover, close when leaving the entire nav bar.
 *
 * The panel uses position:fixed so it is in the viewport stacking context,
 * guaranteeing it renders above all page content and receives pointer events.
 * The top position is calculated from the nav bar's bounding rect.
 */
document.addEventListener('DOMContentLoaded', () => {
    const navBar  = document.querySelector('.main-navigation-bar');
    if (!navBar) return;

    const megaItems    = navBar.querySelectorAll('.main-navigation .menu > li.has-mega-menu');
    const regularItems = navBar.querySelectorAll('.main-navigation .menu > li.menu-item-has-children:not(.has-mega-menu)');
    if (!megaItems.length) return;

    let closeTimer = null;

    // Position all mega menu panels below the nav bar.
    function positionPanels() {
        const bottom = navBar.getBoundingClientRect().bottom;
        megaItems.forEach(item => {
            const panel = item.querySelector(':scope > .mega-menu');
            if (panel) panel.style.top = bottom + 'px';
        });
    }

    function closeAll() {
        megaItems.forEach(i => i.classList.remove('mega-open'));
        regularItems.forEach(i => i.classList.remove('submenu-open'));
    }

    function scheduleClose() {
        clearTimeout(closeTimer);
        closeTimer = setTimeout(closeAll, 100);
    }

    // Open the correct mega menu panel.
    megaItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            positionPanels();
            closeAll();
            item.classList.add('mega-open');
        });

        // Keep open while mouse is inside the panel itself.
        const panel = item.querySelector(':scope > .mega-menu');
        if (panel) {
            panel.addEventListener('mouseenter', () => clearTimeout(closeTimer));
            panel.addEventListener('mouseleave', scheduleClose);
        }
    });

    // Open regular submenus.
    regularItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            closeAll();
            item.classList.add('submenu-open');
        });
    });

    // Close when leaving plain nav items.
    const plainItems = navBar.querySelectorAll('.main-navigation .menu > li:not(.menu-item-has-children):not(.has-mega-menu)');
    plainItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            clearTimeout(closeTimer);
            closeAll();
        });
    });

    // Close when mouse leaves the nav bar (but NOT when entering a fixed panel).
    navBar.addEventListener('mouseleave', scheduleClose);
    navBar.addEventListener('mouseenter', () => clearTimeout(closeTimer));

    // Keep position correct on scroll and resize.
    window.addEventListener('scroll', positionPanels, { passive: true });
    window.addEventListener('resize', positionPanels, { passive: true });

    positionPanels();
});
