// Contact popups inside a swiper are clipped by overflow:hidden.
// Solution: portal the popup to <body> and position it via getBoundingClientRect.
document.addEventListener('DOMContentLoaded', () => {
    let activePortal = null;

    function removePortal() {
        if (activePortal) {
            activePortal.remove();
            activePortal = null;
        }
    }

    document.querySelectorAll('.swiper .contact-icon-wrapper').forEach(wrapper => {
        const popupText = wrapper.querySelector('.popup-text');
        if (!popupText) return;

        wrapper.addEventListener('mouseenter', () => {
            removePortal();

            const rect = wrapper.getBoundingClientRect();
            const portal = document.createElement('div');
            portal.style.cssText = `
                position: fixed;
                z-index: 9999;
                pointer-events: none;
                left: ${rect.left + rect.width / 2}px;
                top: ${rect.top}px;
                transform: translate(-50%, calc(-100% - 4px));
            `;
            portal.appendChild(popupText.cloneNode(true));
            document.body.appendChild(portal);
            activePortal = portal;
        });

        wrapper.addEventListener('mouseleave', removePortal);
    });
});
