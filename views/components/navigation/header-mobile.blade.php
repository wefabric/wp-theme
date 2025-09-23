@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }

    $logoToDisplay = '';
    if (isset($options['navigation_logo']) && $options['navigation_logo'] === 'logo_2') {
        $logoToDisplay = 'logo_white';
    } else {
        $logoToDisplay = 'logo';
    }

    $mobileLogoToDisplay = '';
    if (isset($options['mobile_navigation_logo']) && $options['mobile_navigation_logo'] === 'logo_2') {
        $mobileLogoToDisplay = 'logo_white';
    } else {
        $mobileLogoToDisplay = 'logo';
    }

    $mobileMenuBackgroundColor = $options['mobile_menu_background_color'] ?? 'primary';


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

    $menuType = $options['mobile_menu_type'] ?? 'desktop_menu"';
@endphp

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
        <div class="hamburger-navigation flex items-center gap-x-2 xl:hidden mt-5">

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
    <div class="block xl:hidden mobile-menu-wrap">
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

            <nav id="site-navigation" class="main-navigation">
                @if ($menuType == 'desktop_menu')
                    <li class="home-item menu-item menu-item-object-page {{ Request::is('/') ? 'current-menu-item current_page_item' : '' }}">
                        <a href="<?php echo home_url(); ?>">Home</a>
                    </li>
                    {!! wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id' => 'primary-menu',
                        'echo' => false
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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var menuItems = document.querySelectorAll('.menu-item-has-children');
        var ARROW_HITBOX = 36 + 12; // arrow-size (36) + right padding (12) -> keep in sync with CSS vars

        menuItems.forEach(function (item) {
            item.addEventListener('click', function (event) {
                const li   = event.currentTarget;                  // this <li>
                const link = li.querySelector(':scope > a');       // only the direct link

                // Is the click on the direct link (or anything inside it)?
                const clickedLink = event.target.closest('a') === link;

                // Is the click within the arrow hitbox on the right?
                const rect = li.getBoundingClientRect();
                const clickX = event.clientX;
                const inArrowZone = (rect.right - clickX) <= ARROW_HITBOX;

                if (clickedLink && !inArrowZone) {
                    // normal navigation for link clicks (outside arrow zone)
                    return; // let the browser navigate
                }

                // From here, we toggle this li only (arrow zone or elsewhere in the li)
                event.preventDefault();
                event.stopPropagation(); // <-- prevents parent from also toggling
                li.classList.toggle('open');
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
