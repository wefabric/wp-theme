@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }
@endphp

<input type="checkbox" class="hidden" id="nav-mobile-active" autocomplete="off">

<div class="logo-mobile float-left xl:hidden z-10 relative">
    <div class="site-title">
        <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
            @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'max-h-12 w-auto']) !!}
            @endif
        </a>
    </div>
</div>

<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>
<header class="banner absolute left-0 w-full">
        <div class="flex xl:hidden pt-[28px]">

            <div class="hamburger-menu z-50">
                <label for="nav-mobile-active"
                       class="mb-0 toggle-mobile-menu hamburger-button inline-block align-bottom ">
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                </label>
            </div>

        </div>
        <div class="block xl:hidden mobile-menu-wrap">
            <nav class="mobile-menu">
                <div class="mobile-logo">
                    @include('components.header.logo', ['type' => 'white'])
                </div>

                @if (!empty($options['secondary_menu_show_elements']))
                    <div class="flex gap-2 text-md px-4 pb-4 text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">
                        @foreach($footer_establishments as $key => $establishment_config)
                            @php
                                if ($establishment_config instanceof \Wefabric\WPEstablishments\Establishment) {
                                  $phone = $establishment_config->getContactPhone();
                                  $email = $establishment_config->getContactEmailAddress();
                              } elseif (is_array($establishment_config)) {

                                  $phone = isset($establishment_config['phone']) ? $establishment_config['phone'] : '';
                                  $email = isset($establishment_config['email']) ? $establishment_config['email'] : '';
                              } else {
                                  $phone = '';
                                  $email = '';
                              }
                            @endphp
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
                        @endforeach

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
                                    'container_class' => 'flex',
                                    'li_class'  => 'top-navigation h-full text-sm group flex items-center gap-2 bg-primary-light hover:bg-primary-dark rounded-md text-white',
                                    'li_active_class'  => '',
                                    'echo' => false
                                ]) !!}
                            @endif
                    </div>
                @endif

                <nav id="site-navigation" class="main-navigation">
                    {!! wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id' => 'primary-menu',
                        'echo' => false
                    ]) !!}
                </nav>
            </nav>
        </div>

</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var menuItems = document.querySelectorAll('.menu-item-has-children');
        menuItems.forEach(function (item) {
            var link = item.querySelector('a');
            item.addEventListener('click', function (event) {
                if (event.target === link) { //if the click is on the link, navigate
                    location.href = link.href;
                } else { //otherwise toggle the class
                    item.classList.toggle('open');
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

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                logo.style.opacity = '0';
            } else {
                logo.style.opacity = '100';
            }
        });
    });
</script>