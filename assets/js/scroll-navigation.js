/**
 * Scroll Navigation
 *
 * Verwerkt het scroll-gedrag van de navigatie:
 * - Verberg/toon de navigatiebalk bij scrollen (hide-on-scroll)
 * - Voeg een 'scrolled' klasse toe zodra de pagina gescrolld is
 * - Ondersteuning voor transparante navigatie met logo-wissel
 * - Ondersteuning voor kleurwisseling bij scrollen
 * - Ondersteuning voor scrolled-staat van de topbalk (secondary nav)
 */

const SCROLL_THRESHOLD = 50;  // px vanaf de top waarop 'scrolled' geactiveerd wordt
const HIDE_DELTA       = 25;  // minimale scroll-afstand voor hide/show

(function initScrollNavigation() {
    const nav          = document.querySelector('.main-navigation-bar');
    const header       = document.querySelector('header#masthead');
    const secondaryNav = document.querySelector('.secondary-navigation');

    if (!nav) return; // geen navigatie op deze pagina

    // Lees configuratie uit data-attributen (vanuit PHP/Blade gezet)
    const isTransparent = nav.dataset.navTransparent === 'true';
    const isSticky      = nav.dataset.navSticky === 'true';
    const bgDefault     = nav.dataset.bgDefault  || '';
    const bgScrolled    = nav.dataset.bgScrolled || bgDefault;
    const textDefault        = nav.dataset.textDefault || '';
    const textScrolled       = nav.dataset.textScrolled || textDefault;
    const activeTextDefault  = nav.dataset.activeTextDefault  || '';
    const activeTextScrolled = nav.dataset.activeTextScrolled || '';

    // Topbalk kleurinstellingen (gezet als data-* op .secondary-navigation)
    const secondaryBgDefault            = secondaryNav ? (secondaryNav.dataset.bgDefault          || '') : '';
    const secondaryBgScrolled          = secondaryNav ? (secondaryNav.dataset.bgScrolled        || '') : '';
    const secondaryTextDefault         = secondaryNav ? (secondaryNav.dataset.textDefault        || '') : '';
    const secondaryActiveTextDefault   = secondaryNav ? (secondaryNav.dataset.activeTextDefault  || '') : '';
    const secondaryTextScrolled        = secondaryNav ? (secondaryNav.dataset.textScrolled       || '') : '';
    const secondaryActiveTextScrolled  = secondaryNav ? (secondaryNav.dataset.activeTextScrolled || '') : '';

    let lastScrollTop = 0;
    let ticking       = false;
    let isScrolled    = false;

    /**
     * Herbereken de hoogte van de secondary nav (voor hide-offset)
     */
    function getSecondaryHeight() {
        return secondaryNav ? secondaryNav.offsetHeight : 0;
    }

    /**
     * Logo wissel: zet het juiste logo op basis van scrollpositie.
     * Twee elementen worden ondersteund:
     *   .logo-img--default  — het standaard logo (altijd zichtbaar tenzij gescrold logo actief is)
     *   .logo-img--scrolled — optioneel alternatief logo na scrollen
     */
    function updateLogoState(scrolledState) {
        const logoDefault  = nav.querySelector('.logo-img--default');
        const logoScrolled = nav.querySelector('.logo-img--scrolled');

        // Geen gescrold logo ingesteld — niets te wisselen
        if (!logoScrolled) return;

        if (scrolledState) {
            if (logoDefault) logoDefault.style.display = 'none';
            logoScrolled.style.display = 'block';
        } else {
            if (logoDefault) logoDefault.style.display = '';
            logoScrolled.style.display = 'none';
        }
    }

    /**
     * Kleur wissel: bg-klassen wisselen op de nav wrapper.
     * Tekstkleur wordt via --nav-text-color custom property gezet (zie applyNavTextColor).
     */
    function applyScrolledColors(scrolledState) {
        if (scrolledState) {
            if (bgScrolled && bgScrolled !== bgDefault) {
                if (bgDefault) nav.classList.remove(bgDefault);
                nav.classList.add(bgScrolled);
            }
        } else {
            if (bgScrolled && bgScrolled !== bgDefault) {
                nav.classList.remove(bgScrolled);
                if (bgDefault) nav.classList.add(bgDefault);
            }
        }
        // Tekstkleur apart afhandelen via custom property
        applyNavTextColor(scrolledState);
    }

    /**
     * Hoofdmenu tekstkleur via CSS custom property --nav-text-color.
     * Werkt ongeacht klassen op <li> elementen (bv. text-white via menu-editor of li_class).
     */
    function applyNavTextColor(scrolledState) {
        const className = (scrolledState && textScrolled) ? textScrolled : textDefault;
        let color = className ? resolveColorFromClass(className) : '';
        if (!color) color = window.getComputedStyle(nav).color;
        if (color) nav.style.setProperty('--nav-text-color', color);
    }

    /**
     * Topbalk achtergrondkleurwissel op basis van scrolled-staat
     */
    function applySecondaryScrolledColors(scrolledState) {
        if (!secondaryNav || !secondaryBgScrolled) return;

        // Alleen wisselen als de scrolled-kleur verschilt van de default-kleur.
        // Als ze gelijk zijn hoeft er niets te gebeuren — de default class staat
        // er al via PHP en mag niet worden verwijderd bij terugscrolling.
        if (secondaryBgScrolled === secondaryBgDefault) return;

        if (scrolledState) {
            if (secondaryBgDefault) secondaryNav.classList.remove(secondaryBgDefault);
            secondaryNav.classList.add(secondaryBgScrolled);
        } else {
            secondaryNav.classList.remove(secondaryBgScrolled);
            if (secondaryBgDefault) secondaryNav.classList.add(secondaryBgDefault);
        }
    }

    /**
     * Topbalk tekstkleur via CSS custom property --secondary-text-color.
     * Werkt ongeacht specificiteit van globale a { color } regels.
     * Fallback: als geen class beschikbaar is, lees de computed color van de wrapper zelf.
     */
    function applySecondaryTextColor(scrolledState) {
        if (!secondaryNav) return;
        const className = (scrolledState && secondaryTextScrolled) ? secondaryTextScrolled : secondaryTextDefault;
        let color = className ? resolveColorFromClass(className) : '';
        // Fallback: als geen class ingesteld, pak de huidige computed color van de wrapper
        if (!color) {
            color = window.getComputedStyle(secondaryNav).color;
        }
        if (color) secondaryNav.style.setProperty('--secondary-text-color', color);
    }

    /**
     * Topbalk actieve (hover) tekstkleur na scrollen via CSS custom property
     */
    function applySecondaryActiveColor(scrolledState) {
        if (!secondaryNav || !secondaryActiveTextScrolled) return;

        if (scrolledState) {
            const color = resolveColorFromClass(secondaryActiveTextScrolled);
            if (color) secondaryNav.style.setProperty('--secondary-active-color', color);
        } else {
            secondaryNav.style.removeProperty('--secondary-active-color');
        }
    }

    /**
     * Lees de werkelijke CSS kleurwaarde op uit een Tailwind class naam.
     *
     * Stap 1: Zoek de CSS custom property die styleCustomizer()->renderCustomColors() zet.
     *         'text-cta'          → '--cta-color'  → '#ff6400'
     *         'text-primary-dark' → '--primary-dark-color' → '#003b69'
     *
     * Stap 2: Fallback via tijdelijk DOM-element voor standaard Tailwind kleuren
     *         zoals 'text-white' of 'text-black' (geen CSS custom property).
     */
    function resolveColorFromClass(className) {
        if (!className) return '';

        // Stap 1: thema-kleur via CSS custom property
        const colorName = className.replace(/^(text|bg)-/, '');
        const propValue = getComputedStyle(document.documentElement)
            .getPropertyValue('--' + colorName + '-color').trim();

        if (propValue) return propValue;

        // Stap 2: standaard Tailwind kleur via tijdelijk DOM-element
        const el = document.createElement('span');
        el.className = className;
        el.style.cssText = 'position:absolute;width:0;height:0;overflow:hidden;visibility:hidden;pointer-events:none;';
        document.documentElement.appendChild(el);
        const color = window.getComputedStyle(el).color;
        el.remove();

        return (color && color !== 'rgba(0, 0, 0, 0)') ? color : '';
    }

    /**
     * Hoofdmenu hover-kleur via --nav-active-color.
     * Gebruikt altijd de juiste kleur: default of scrolled.
     */
    function applyNavActiveColor(scrolledState) {
        const className = (scrolledState && activeTextScrolled) ? activeTextScrolled : activeTextDefault;
        if (!className) return;
        const color = resolveColorFromClass(className);
        if (color) nav.style.setProperty('--nav-active-color', color);
    }

    /**
     * Topbalk hover-kleur via --secondary-active-color.
     * Gebruikt altijd de juiste kleur: default of scrolled.
     */
    function applySecondaryActiveColor(scrolledState) {
        if (!secondaryNav) return;
        const className = (scrolledState && secondaryActiveTextScrolled) ? secondaryActiveTextScrolled : secondaryActiveTextDefault;
        if (!className) return;
        const color = resolveColorFromClass(className);
        if (color) secondaryNav.style.setProperty('--secondary-active-color', color);
    }

    /**
     * Verwerk scroll-events (aangeroepen via requestAnimationFrame)
     */
    function onScroll() {
        const currentScroll   = window.pageYOffset || document.documentElement.scrollTop;
        const secondaryHeight = getSecondaryHeight();
        const navHeight       = nav.offsetHeight;

        // === Scrolled-staat ===
        const shouldBeScrolled = currentScroll > SCROLL_THRESHOLD;

        if (shouldBeScrolled !== isScrolled) {
            isScrolled = shouldBeScrolled;

            // Scrolled-klasse altijd zetten (voor CSS-hooks die niet van sticky afhangen)
            if (isScrolled) {
                nav.classList.add('scrolled');
                if (secondaryNav) secondaryNav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
                if (secondaryNav) secondaryNav.classList.remove('scrolled');
            }

            // Kleur- en logo-wissel bij sticky of transparante navigatie
            if (isSticky || isTransparent) {
                applyScrolledColors(isScrolled);
                applySecondaryScrolledColors(isScrolled);
                applySecondaryTextColor(isScrolled);
                applySecondaryActiveColor(isScrolled);
                applyNavActiveColor(isScrolled);
                updateLogoState(isScrolled);
            }
        }

        // === Hide-on-scroll voor topbalk (alleen als sticky + secondaryNav actief zijn) ===
        // Bij sticky navigatie met een topbalk: schuif de topbalk weg bij scrollen omlaag
        // en laat hem terugkomen bij scrollen omhoog.
        // Zonder sticky staat de header gewoon stil — geen transform.
        if (isSticky && secondaryNav && header && Math.abs(lastScrollTop - currentScroll) > HIDE_DELTA) {
            const scrollingDown = currentScroll > lastScrollTop;

            if (scrollingDown && currentScroll > secondaryHeight) {
                header.style.transform = `translateY(-${secondaryHeight}px)`;
            } else if (!scrollingDown) {
                header.style.transform = 'translateY(0)';
            }

            lastScrollTop = currentScroll;
        }

        ticking = false;
    }

    // ============================================================
    // Transparante nav offset
    // Stel de hoogte van de header in als CSS custom property zodat
    // de content er precies onder valt (negatieve marge via CSS).
    // ============================================================
    function applyTransparentOffset() {
        if (!isTransparent || !header) return;
        const height = header.offsetHeight;
        document.documentElement.style.setProperty('--nav-height', height + 'px');
    }

    applyTransparentOffset();
    window.addEventListener('resize', applyTransparentOffset, { passive: true });

    // Stel initiële logo-staat in (transparant logo tonen bij 0px scroll)
    updateLogoState(false);

    // Initiële tekstkleuren en hover-kleuren instellen via custom properties
    applyNavTextColor(false);
    applyNavActiveColor(false);
    applySecondaryTextColor(false);
    applySecondaryActiveColor(false);

    // Submenu kleuren — zelfde aanpak als nav-tekst kleuren via resolveColorFromClass
    const submenuBgClass         = nav.dataset.submenuBg         || '';
    const submenuTextClass       = nav.dataset.submenuText       || '';
    const submenuActiveTextClass = nav.dataset.submenuActiveText || '';
    if (submenuBgClass)         { const c = resolveColorFromClass(submenuBgClass);         if (c) { nav.style.setProperty('--submenu-bg',          c); if (secondaryNav) secondaryNav.style.setProperty('--submenu-bg',          c); } }
    if (submenuTextClass)       { const c = resolveColorFromClass(submenuTextClass);       if (c) { nav.style.setProperty('--submenu-text-color',   c); if (secondaryNav) secondaryNav.style.setProperty('--submenu-text-color',   c); } }
    if (submenuActiveTextClass) { const c = resolveColorFromClass(submenuActiveTextClass); if (c) { nav.style.setProperty('--submenu-active-color', c); if (secondaryNav) secondaryNav.style.setProperty('--submenu-active-color', c); } }

    // Mobiele menu kleuren — eenmalig op load, nooit aangepast bij scrollen
    const mobileWrap = document.querySelector('.mobile-menu-wrap');
    if (mobileWrap) {
        const mobileTextColor   = resolveColorFromClass(mobileWrap.dataset.mobileText   || '');
        const mobileActiveColor = resolveColorFromClass(mobileWrap.dataset.mobileActive || '');
        if (mobileTextColor)   mobileWrap.style.setProperty('--mobile-text-color',   mobileTextColor);
        if (mobileActiveColor) mobileWrap.style.setProperty('--mobile-active-color', mobileActiveColor);
    }

    // Initiële controle voor page-refresh halverwege de pagina
    if (window.scrollY > SCROLL_THRESHOLD) {
        isScrolled = true;
        nav.classList.add('scrolled');
        if (secondaryNav) secondaryNav.classList.add('scrolled');

        if (isSticky || isTransparent) {
            applyScrolledColors(true);
            applySecondaryScrolledColors(true);
            applySecondaryTextColor(true);
            applySecondaryActiveColor(true);
            applyNavActiveColor(true);
            updateLogoState(true);
        }
    }

    // Voeg nav-ready toe ná de eerste paint zodat transitions niet
    // de initiële beginstaat animeren maar alleen bij scroll/resize.
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            nav.classList.add('nav-ready');
            if (header) header.classList.add('nav-ready');
        });
    });

    window.addEventListener('scroll', function () {
        if (!ticking) {
            window.requestAnimationFrame(onScroll);
            ticking = true;
        }
    }, { passive: true });

    window.addEventListener('resize', function () {
        lastScrollTop = window.scrollY;
    }, { passive: true });
})();
