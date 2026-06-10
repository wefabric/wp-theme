@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }

    // Nav-instellingen zitten in ACF group 'nav' — merge terug naar root niveau
    if (!empty($options['nav']) && is_array($options['nav'])) {
        $options = array_merge($options, $options['nav']);
        if (!empty($options['nav']['desktop']) && is_array($options['nav']['desktop'])) {
            $options = array_merge($options, $options['nav']['desktop']);
        }
    }

    $logoMap = [
        'logo_1'       => 'logo',
        'logo_2'       => 'logo_white',
        'logo_3'       => 'logo_3',
        'logo_1_small' => 'logo_1_small',
        'logo_2_small' => 'logo_2_small',
        'logo_3_small' => 'logo_3_small',
    ];
    $logoToDisplay       = $logoMap[$options['navigation_logo'] ?? 'logo_1'] ?? 'logo';
    $mobileLogoToDisplay = $logoMap[$options['mobile_navigation_logo'] ?? 'logo_1'] ?? 'logo';

    $mobileMenuBackgroundColor = $options['mobile_menu_background_color'] ?? 'primary';
    $mobileMenuTextColor       = $options['mobile_menu_text_color'] ?? 'white';
    $mobileMenuActiveTextColor = $options['mobile_menu_active_text_color'] ?? 'cta';


    $phone = '';
    $email = '';
    foreach($footer_establishments as $key => $establishment) {
        if ($establishment instanceof \Wefabric\WPEstablishments\Establishment) {
            $phone = $establishment->getContactPhone();
            $email = $establishment->getContactEmailAddress();
        } elseif (is_array($establishment)) {
            $establishment = new \Wefabric\WPEstablishments\Establishment($establishment['establishment']);
            $phone = $establishment->getContactPhone();
            $email = $establishment->getContactEmailAddress();
        }
        break;
    }

    $menuType          = $options['mobile_menu_type']    ?? 'desktop_menu';
    $mobileMenuVersion = $options['mobile_menu_version'] ?? 'v1';
@endphp

@if ($mobileMenuVersion === 'v2')
    @php add_filter('body_class', fn($c) => array_merge($c, ['mobile-menu-v2'])) @endphp
@endif

<input type="checkbox" class="hidden" id="nav-mobile-active" autocomplete="off">

<div class="logo-mobile float-left xl:hidden z-10 relative">
    <div class="site-title">
        <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
            @if(isset(get_field('common', 'option')[$logoToDisplay]) && $logoId = get_field('common', 'option')[$logoToDisplay])
                {!! wp_get_attachment_image($logoId, 'full', false, ['class' => 'max-h-12 w-auto']) !!}
            @endif
            <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
        </a>
    </div>
</div>

<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>
<header class="banner absolute left-0 w-full">
    <div class="hamburger-menu z-50">
        <div class="hamburger-navigation flex items-center gap-x-2 xl:hidden">

            @if($phone)
                <a href="tel:{{ $phone }}" title="Telefoonnummer"
                   class="phone-link h-[30px] w-[30px] bg-primary text-white rounded-full block text-center flex justify-center items-center">
                    <i class="fa fa-phone"></i>
                </a>
            @endif

            @if($email)
                <a href="mailto:{{ $email }}" title="E-mailadres"
                   class="mail-link h-[30px] w-[30px] bg-primary text-white rounded-full block text-center flex justify-center items-center">
                    <i class="fa fa-envelope"></i>
                </a>
            @endif

            <label for="nav-mobile-active"
                   class="mb-0 toggle-mobile-menu hamburger-button inline-block align-bottom">
                <span class="hamburger-button-bar"></span>
                <span class="hamburger-button-bar"></span>
                <span class="hamburger-button-bar"></span>
            </label>
        </div>

    </div>
    <div class="block xl:hidden mobile-menu-wrap"
         data-mobile-text="text-{{ str_replace('-color', '', $mobileMenuTextColor) }}"
         data-mobile-active="text-{{ str_replace('-color', '', $mobileMenuActiveTextColor) }}">
        <nav class="mobile-menu flex flex-col bg-{{ $mobileMenuBackgroundColor }}">
            <div class="mobile-logo">
                <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
                    @if(isset(get_field('common', 'option')[$mobileLogoToDisplay]) && $logoId = get_field('common', 'option')[$mobileLogoToDisplay])
                        {!! wp_get_attachment_image($logoId, 'header_logo', false, ['class' => 'w-full']) !!}
                    @endif
                    <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
                </a>
            </div>

            @if (!empty($options['secondary_menu_show_elements']))
                <div class="top-navigation flex flex-col gap-2 text-md px-4 pb-4 text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">
                    @if (in_array('phone', $options['secondary_menu_show_elements']) || in_array('email', $options['secondary_menu_show_elements']))
                        <div class="contact-info flex gap-x-2">
                            @if (in_array('phone', $options['secondary_menu_show_elements']))
                                <a class="phone-link group flex items-center" href="tel:{{ $phone }}"
                                   title="Telefoonnummer">
                                    <i class="p-2 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-phone"></i>
                                    <span class="align-middle"></span>
                                </a>
                            @endif
                            @if (in_array('email', $options['secondary_menu_show_elements']))
                                <a class="mail-link group flex items-center" href="mailto:{{ $email }}"
                                   title="E-mailadres">
                                    <i class="p-2 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-envelope"></i>
                                    <span class="align-middle"></span>
                                </a>
                            @endif
                        </div>
                    @endif

                    @if ($menuType == 'desktop_menu')
                        @if (in_array('top_navigation', $options['secondary_menu_show_elements']))
                            @php
                                $menuLocations = get_nav_menu_locations();
                                $menuID = null;
                                if(isset($menuLocations['top-navigation'])) {
                                    $menuID = $menuLocations['top-navigation'];
                                }
                            @endphp
                            @if(isset($menuID) && !is_null($menuID))
                                {!! wp_nav_menu([
                                    'theme_location' => 'top-navigation',
                                    'menu_id' => $menuID,
                                    'container_class' => 'secondary-menu-items flex',
                                    'li_class'  => 'li-class',
                                    'li_active_class'  => '',
                                    'echo' => false
                                ]) !!}
                            @endif

                        @endif
                    @endif
                </div>
            @endif

            @php
                // Tekstkleur direct als Tailwind class op de nav zetten.
                // CSS forceert li + a om deze kleur te erven (zie _navigation.scss).
                $mobileTextClass = 'text-' . str_replace('-color', '', $mobileMenuTextColor ?: 'white');
                // Actieve kleur via CSS custom property die verwijst naar de styleCustomizer variabele.
                // 'cta-color' → var(--cta-color), 'white-color' → var(--white-color, white)
                $mobileActiveColorVar = 'var(--' . ($mobileMenuActiveTextColor ?: 'cta-color') . ')';
            @endphp
            <nav id="site-navigation"
                 class="main-navigation {{ $mobileTextClass }}"
                 style="--mobile-active-color: {{ $mobileActiveColorVar }};">
                @if ($menuType == 'desktop_menu')
                    <li class="home-item menu-item menu-item-object-page {{ Request::is('/') ? 'current-menu-item current_page_item' : '' }}">
                        <a href="<?php echo home_url(); ?>">Home</a>
                    </li>
                    {!! wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id' => 'primary-menu',
                        'echo' => false,
                        'disable_mega_menu' => true,
                    ]) !!}
                @elseif ($menuType == 'mobile_menu')
                    {!! wp_nav_menu([
                        'theme_location' => 'mobile-menu',
                        'menu_id' => 'primary-menu',
                        'echo' => false
                    ]) !!}
                @endif
            </nav>
        </nav>
    </div>

</header>

@if ($mobileMenuVersion === 'v2')
{{-- ============================================================ --}}
{{-- Versie 2: fullscreen overlay — wordt via JS naar <body> verplaatst --}}
{{-- De bestaande hamburger label triggert dit menu via JS. --}}
{{-- ============================================================ --}}
<div class="mnav2-overlay bg-{{ $mobileMenuBackgroundColor }} text-{{ str_replace('-color', '', $mobileMenuTextColor) }}"
     id="mnav2-overlay"
     aria-hidden="true"
     role="dialog"
     aria-modal="true"
     data-active-color="text-{{ str_replace('-color', '', $mobileMenuActiveTextColor) }}">
    <div class="mnav2-overlay__inner">

        {{-- Logo --}}
        <div class="mnav2-overlay__logo">
            <a href="{{ esc_url(home_url('/')) }}" aria-label="home">
                @if(isset(get_field('common', 'option')[$mobileLogoToDisplay]) && $logoId = get_field('common', 'option')[$mobileLogoToDisplay])
                    {!! wp_get_attachment_image($logoId, 'full', false, ['class' => 'max-h-12 w-auto']) !!}
                @endif
            </a>
        </div>

        {{-- Nav --}}
        <nav class="mnav2-overlay__nav" aria-label="Mobiele navigatie">
            @php
                $mnav2MenuArgs = [
                    'theme_location' => $menuType === 'mobile_menu' ? 'mobile-menu' : 'menu-1',
                    'menu_id'        => 'mnav2-menu',
                    'menu_class'     => 'mnav2-overlay__list',
                    'echo'           => false,
                    'disable_mega_menu' => true,
                    'walker'         => new Walker_Nav_Menu(),
                ];
            @endphp
            {!! wp_nav_menu($mnav2MenuArgs) !!}
        </nav>

        {{-- Topbalk-elementen (secondary menu) --}}
        @if (!empty($options['show_secondary_menu']) && !empty($options['secondary_menu_show_elements']))
            <div class="mnav2-overlay__secondary">
                @if (in_array('top_navigation', $options['secondary_menu_show_elements']))
                    @php
                        $menuLocations = get_nav_menu_locations();
                        $topNavMenuId  = $menuLocations['top-navigation'] ?? null;
                    @endphp
                    @if ($topNavMenuId)
                        {!! wp_nav_menu([
                            'theme_location'  => 'top-navigation',
                            'menu_id'         => $topNavMenuId,
                            'container_class' => 'mnav2-overlay__secondary-nav',
                            'echo'            => false,
                        ]) !!}
                    @endif
                @endif

                @if (in_array('phone', $options['secondary_menu_show_elements']) && $phone)
                    <a href="tel:{{ $phone }}" class="mnav2-overlay__contact">
                        <i class="fa fa-phone mr-2"></i>{{ $phone }}
                    </a>
                @endif

                @if (in_array('email', $options['secondary_menu_show_elements']) && $email)
                    <a href="mailto:{{ $email }}" class="mnav2-overlay__contact">
                        <i class="fa fa-envelope mr-2"></i>{{ $email }}
                    </a>
                @endif

                @if (in_array('whatsapp', $options['secondary_menu_show_elements']) && !empty($options['whatsapp_link']))
                    <a href="{{ $options['whatsapp_link'] }}" class="mnav2-overlay__contact" target="_blank" rel="noopener">
                        <i class="fa fa-whatsapp mr-2"></i>{{ $options['whatsapp_text'] ?? 'WhatsApp' }}
                    </a>
                @endif
            </div>
        @endif

        {{-- Footer: vestigingscontactinfo (fallback als topbalk uit staat) --}}
        @if (empty($options['show_secondary_menu']))
            <footer class="mnav2-overlay__footer text-{{ str_replace('-color', '', $mobileMenuTextColor) }}">
                @if($phone)
                    <a href="tel:{{ $phone }}" class="mnav2-overlay__contact">
                        <i class="fa fa-phone mr-2"></i>{{ $phone }}
                    </a>
                @endif
                @if($email)
                    <a href="mailto:{{ $email }}" class="mnav2-overlay__contact">
                        <i class="fa fa-envelope mr-2"></i>{{ $email }}
                    </a>
                @endif
            </footer>
        @endif
    </div>
</div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var menuItems = document.querySelectorAll('.menu-item-has-children');
        var ARROW_HITBOX = 36 + 12; // arrow-size (36) + right padding (12)

        menuItems.forEach(function (item) {
            item.addEventListener('click', function (event) {
                // Op desktop: mega menu items en hun children altijd door laten navigeren
                if (window.innerWidth >= 1280) {
                    if (item.classList.contains('has-mega-menu')) return;
                    if (event.target.closest('.mega-menu')) return;
                }

                const li = event.currentTarget;
                const link = li.querySelector(':scope > a');

                const rect = li.getBoundingClientRect();
                const clickX = event.clientX;
                const inArrowZone = (rect.right - clickX) <= ARROW_HITBOX;

                const clickedLink = event.target.closest('a') === link;

                if (clickedLink && !inArrowZone) {
                    // Klik op link buiten pijltje -> navigeer
                    return;
                }

                // Klik op pijltje of ergens anders in <li> -> toggle submenu
                event.preventDefault(); // voorkom navigatie
                li.classList.toggle('open');
            });
        });

        // voorkom dat clicks binnen submenu's bubbling veroorzaken
        document.querySelectorAll('.menu-item-has-children > ul').forEach(function(submenu) {
            submenu.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });

        // Desktop submenu overflow detection
        var desktopMenuItems = document.querySelectorAll('.menu-item-has-children');
        desktopMenuItems.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                if (window.innerWidth >= 1280) {
                    var submenu = this.querySelector('.sub-menu');
                    if (submenu) {
                        this.classList.remove('open-left');
                        var rect = submenu.getBoundingClientRect();

                        if (rect.width === 0) {
                            submenu.style.visibility = 'hidden';
                            submenu.style.display = 'block';
                            rect = submenu.getBoundingClientRect();
                            submenu.style.display = '';
                            submenu.style.visibility = '';
                        }

                        if (rect.right > (window.innerWidth || document.documentElement.clientWidth)) {
                            this.classList.add('open-left');
                        }
                    }
                }
            });

            item.addEventListener('mouseleave', function () {
                if (window.innerWidth >= 1280) {
                    this.classList.remove('open-left');
                }
            });
        });
    });
</script>



<style>
    .main-navigation .menu {
        margin-bottom: 0 !important;
    }

    .hamburger-secondary-menu {
        display: flex !important;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var checkbox = document.getElementById('nav-mobile-active');
        var logo = document.querySelector('.logo-mobile');
        var anchor = logo.querySelector('.site-title a');
        var originalHref = anchor.getAttribute('href');

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                logo.style.opacity = '0';
                anchor.removeAttribute('href');
                anchor.addEventListener('click', preventDefault);
            } else {
                logo.style.opacity = '100';
                anchor.setAttribute('href', originalHref);
                anchor.removeEventListener('click', preventDefault);
            }
        });

        function preventDefault(event) {
            event.preventDefault();
        }
    });
</script>
