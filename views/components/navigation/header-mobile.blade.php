<input type="checkbox" class="hidden" id="nav-mobile-active">
<div class="logo-mobile float-left lg:hidden">
    <div class="site-title">
        <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
            @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'max-h-12 w-auto']) !!}
            @endif
        </a>
    </div>
</div>
<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>
@php
//    $contact_information = get_fields('option');
@endphp
<header class="banner absolute left-0 w-full">
    <div>
        <div class="py-6 flex items-center lg:hidden">
            <div class="hamburger-menu z-50">
                <label for="nav-mobile-active" class="mb-0 toggle-mobile-menu hamburger-button">
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                </label>
            </div>
        </div>
        <div class="mobile-menu-wrap">
            <nav class="mobile-menu">
                <div class="mb-3 mobile-logo">
                    @include('components.header.logo', ['type' => 'white'])
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

    </div>
</header>
