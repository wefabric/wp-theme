/**
 * Mobiel menu versie 2 — fullscreen overlay met circulaire reveal + drill-down navigatie.
 *
 * De hamburger wordt NOOIT verplaatst. In plaats daarvan wordt een vaste clone
 * aangemaakt die altijd boven de overlay zweeft (z-index 10001). De clone
 * synchroniseert positie en kleur met de originele knop.
 */
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('mnav2-overlay');
    if (!overlay) return;

    document.body.appendChild(overlay);

    const hamburgerLabel = document.querySelector('.toggle-mobile-menu');
    const checkbox       = document.getElementById('nav-mobile-active');

    // ── Clone aanmaken ───────────────────────────────────────────────────────
    // De clone is een identieke knop die altijd position:fixed boven de overlay
    // staat. De originele hamburger blijft onaangeroerd in de header.
    const clone = document.createElement('label');
    clone.className = hamburgerLabel ? hamburgerLabel.className : 'hamburger-button';
    clone.innerHTML = '<span class="hamburger-button-bar"></span>'
                    + '<span class="hamburger-button-bar"></span>'
                    + '<span class="hamburger-button-bar"></span>';
    clone.style.cssText = 'position:fixed;z-index:10001;display:none;cursor:pointer;';
    document.body.appendChild(clone);

    const cloneBars = clone.querySelectorAll('.hamburger-button-bar');

    // Sync clone positie met de originele knop
    const syncPosition = () => {
        if (!hamburgerLabel) return;
        const r = hamburgerLabel.getBoundingClientRect();
        clone.style.top  = r.top  + 'px';
        clone.style.left = r.left + 'px';
    };

    // Sync clone barkleur (kan veranderen via scroll/nav-kleur JS)
    const syncBarColor = () => {
        if (!hamburgerLabel) return;
        const origBar = hamburgerLabel.querySelector('.hamburger-button-bar');
        if (!origBar) return;
        const color = window.getComputedStyle(origBar).backgroundColor;
        cloneBars.forEach(b => { b.style.backgroundColor = color; });
    };

    // ── Actieve kleur overlay ────────────────────────────────────────────────
    const resolveClass = cls => {
        if (!cls) return '';
        const tmp = document.createElement('span');
        tmp.className = cls;
        tmp.style.cssText = 'position:absolute;width:0;height:0;overflow:hidden;visibility:hidden;';
        document.body.appendChild(tmp);
        const color = window.getComputedStyle(tmp).color;
        tmp.remove();
        return (color && color !== 'rgba(0, 0, 0, 0)') ? color : '';
    };

    const activeColor = resolveClass(overlay.dataset.activeColor || '');
    if (activeColor) overlay.style.setProperty('--mnav2-active-color', activeColor);

    const overlayTextColor = window.getComputedStyle(overlay).color;
    if (overlayTextColor) document.documentElement.style.setProperty('--mnav2-text-color', overlayTextColor);

    // ── Open / sluiten ───────────────────────────────────────────────────────
    let isOpen       = false;
    let cleanupTimer = null;

    const animateTo = (toOpen) => {
        cloneBars.forEach(b => {
            b.style.transition = 'transform 0.3s ease-out, opacity 0.3s ease';
        });
        cloneBars[0].style.transform = toOpen ? 'rotate(45deg)' : '';
        cloneBars[1].style.opacity   = toOpen ? '0' : '';
        cloneBars[2].style.transform = toOpen ? 'rotate(-45deg)' : '';
    };

    const showClone = () => {
        syncPosition();
        cloneBars.forEach(b => { b.style.backgroundColor = overlayTextColor || ''; });
        clone.style.display = 'block';
        if (hamburgerLabel) hamburgerLabel.style.opacity = '0';
    };

    const hideClone = () => {
        if (hamburgerLabel) hamburgerLabel.style.opacity = '';
        clone.style.display = 'none';
        cloneBars.forEach(b => {
            b.style.transition      = '';
            b.style.backgroundColor = '';
            b.style.transform       = '';
            b.style.opacity         = '';
        });
    };

    const open = () => {
        if (isOpen) return;
        isOpen = true;

        // Cancel eventuele lopende cleanup van een vorige close()
        clearTimeout(cleanupTimer);

        showClone();
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        if (checkbox) checkbox.checked = false;

        requestAnimationFrame(() => requestAnimationFrame(() => animateTo(true)));
    };

    const close = () => {
        if (!isOpen) return;
        isOpen = false;

        // Cancel eventuele lopende cleanup
        clearTimeout(cleanupTimer);

        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (checkbox) checkbox.checked = false;

        animateTo(false);

        cleanupTimer = setTimeout(() => {
            // Alleen uitvoeren als het menu nog steeds gesloten is
            if (!isOpen) {
                hideClone();
                // Reset alle panels terug naar root
                panelsWrap.querySelectorAll('.mnav2-panel').forEach(p => {
                    p.classList.remove('mnav2-panel--active', 'mnav2-panel--exit-left');
                });
                rootPanel.classList.add('mnav2-panel--active');
                activePanel = rootPanel;
            }
        }, 720); // Wacht tot de overlay clip-path animatie (0.7s) volledig klaar is
    };

    // Klik op originele hamburger OF clone → toggle
    [hamburgerLabel, clone].forEach(el => {
        if (!el) return;
        el.addEventListener('click', e => {
            e.preventDefault();
            isOpen ? close() : open();
        });
    });

    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && isOpen) close();
    });

    // Positie bijwerken bij resize (bijv. orientatiewijziging)
    window.addEventListener('resize', () => { if (isOpen) syncPosition(); }, { passive: true });

    // ── Panels bouwen ────────────────────────────────────────────────────────
    const nav = overlay.querySelector('.mnav2-overlay__nav');
    if (!nav) return;

    const panelsWrap = document.createElement('div');
    panelsWrap.className = 'mnav2-panels';
    nav.appendChild(panelsWrap);

    const rootList = nav.querySelector('.mnav2-overlay__list');
    if (!rootList) return;

    const rootPanel = document.createElement('div');
    rootPanel.className = 'mnav2-panel mnav2-panel--active';
    rootPanel.dataset.depth = '0';
    panelsWrap.appendChild(rootPanel);
    rootPanel.appendChild(rootList);

    let activePanel = rootPanel;

    // Navigeer naar een specifiek panel (voor breadcrumb klikken)
    const navigateTo = (targetPanel) => {
        // Reset alle panels en activeer target
        panelsWrap.querySelectorAll('.mnav2-panel').forEach(p => {
            p.classList.remove('mnav2-panel--active', 'mnav2-panel--exit-left');
        });
        targetPanel.classList.add('mnav2-panel--active');
        activePanel = targetPanel;
        overlay.querySelector('.mnav2-overlay__inner').scrollTop = 0;
    };

    // Bouw breadcrumb op één regel: ‹ Ancestor1 / Ancestor2 / HuidigLabel
    const buildPanelHeader = (currentLabel, parentPanel, ancestors) => {
        const nav = document.createElement('nav');
        nav.className = 'mnav2-breadcrumb';

        // Terug-pijl
        const backBtn = document.createElement('button');
        backBtn.className = 'mnav2-back';
        backBtn.innerHTML = '<i class="fa fa-chevron-left"></i>';
        backBtn.addEventListener('click', () => navigateTo(parentPanel));
        nav.appendChild(backBtn);

        // Klikbare ancestor labels + separator
        ancestors.forEach(({ label, panel }) => {
            const crumb = document.createElement('button');
            crumb.className = 'mnav2-crumb';
            crumb.textContent = label;
            crumb.addEventListener('click', () => navigateTo(panel));
            nav.appendChild(crumb);

            const sep = document.createElement('span');
            sep.className = 'mnav2-crumb-sep';
            sep.textContent = '/';
            nav.appendChild(sep);
        });

        // Huidige naam — niet klikbaar, iets feller
        const current = document.createElement('span');
        current.className = 'mnav2-crumb-current';
        current.textContent = currentLabel;
        nav.appendChild(current);

        return nav;
    };

    // Bouw recursief panels voor elk niveau
    // ancestors = array van {label, panel} van root tot huidig parent
    const buildSubPanel = (parentList, parentPanel, ancestors) => {
        parentList.querySelectorAll(':scope > li.menu-item-has-children').forEach(li => {
            const link    = li.querySelector(':scope > a');
            const subList = li.querySelector(':scope > .sub-menu');
            if (!subList) return;

            const label = link ? link.textContent.trim() : '';

            // Pijl-knop naast het menu item
            const arrow = document.createElement('button');
            arrow.className = 'mnav2-arrow';
            arrow.setAttribute('aria-label', `Toon subitems van ${label}`);
            arrow.innerHTML = '<i class="fa fa-chevron-right"></i>';
            li.appendChild(arrow);

            // Sub-panel
            const subPanel = document.createElement('div');
            subPanel.className = 'mnav2-panel';
            subPanel.dataset.depth = String(ancestors.length + 1);
            panelsWrap.appendChild(subPanel);

            // Header: terug-pijl + breadcrumb + paneeltitel
            const header = buildPanelHeader(label, parentPanel, ancestors);
            subPanel.appendChild(header);

            // Sub-lijst
            subPanel.appendChild(subList);
            subList.classList.add('mnav2-sublist');

            // Recursief: voeg dit niveau toe aan ancestors voor het volgende niveau
            // { label: huidig label, panel: subPanel } = klik op dit crumb → ga naar subPanel
            buildSubPanel(subList, subPanel, [...ancestors, { label, panel: subPanel }]);

            // Navigeer naar sub-panel
            arrow.addEventListener('click', e => {
                e.preventDefault();
                e.stopPropagation();
                activePanel.classList.remove('mnav2-panel--active');
                activePanel.classList.add('mnav2-panel--exit-left');
                subPanel.classList.add('mnav2-panel--active');
                activePanel = subPanel;
                overlay.querySelector('.mnav2-overlay__inner').scrollTop = 0;
            });
        });
    };

    buildSubPanel(rootList, rootPanel, []);

    // ── Regel-stabiliteit bij hover ──────────────────────────────────────────
    // Sub-lijst-items krijgen op hover iets meer letter-spacing. Voor een item dat
    // toevallig precies op de rand van één regel balanceert, kan die kleine
    // verbreding het over de rand duwen naar een 2e regel — een layout-shift die
    // niet bij hover mag gebeuren. In plaats van de hover-letter-spacing te
    // schrappen (en zo het effect overal te verliezen), meten we per item of het
    // MET de hover-breedte al niet meer op één regel past, en forceren we dat
    // dan meteen (rest én hover), zodat hover het aantal regels nooit meer wijzigt.
    const HOVER_LETTER_SPACING = '0.03em';

    document.querySelectorAll('.mnav2-sublist li > a').forEach((link) => {
        // Meet de daadwerkelijke, natuurlijk gewrapte hoogte bij rust vs. bij de
        // hover-letter-spacing — zelfde mechanisme als de echte :hover, dus
        // exact representatief voor wat er ook echt gebeurt (i.p.v. een losse
        // nowrap/scrollWidth-berekening die het flex-wrap-gedrag niet exact
        // nabootst). De CSS-transitie op letter-spacing wordt tijdens het meten
        // uitgezet, anders lees je via clientHeight de beginwaarde van de
        // transitie i.p.v. de daadwerkelijk ingestelde waarde.
        const originalTransition = link.style.transition;
        const originalLetterSpacing = link.style.letterSpacing;

        link.style.transition = 'none';
        const restHeight = link.clientHeight;

        link.style.letterSpacing = HOVER_LETTER_SPACING;
        void link.offsetHeight; // force reflow zodat de nieuwe waarde direct geldt
        const hoverHeight = link.clientHeight;

        link.style.letterSpacing = originalLetterSpacing;
        void link.offsetHeight;
        link.style.transition = originalTransition;

        if (hoverHeight > restHeight) {
            link.classList.add('mnav2-link--wraps');
        }
    });
});
