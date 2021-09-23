<input type="checkbox" class="hidden" id="nav-mobile-active">
<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>
@php
    $contact_information = get_fields('option');
@endphp
<header class="banner z-2 absolute w-full">
    <div>
        <div class="py-3 flex items-center lg:hidden">
            <div class="hamburger-menu">
                <label for="nav-mobile-active" class="mb-0 toggle-mobile-menu hamburger-button">
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                </label>
            </div>
        </div>
        <nav class="mobile-menu">
            <div class="mb-3 mobile-logo">
                @include('components.header.logo')
            </div>
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
