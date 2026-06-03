@php
    $options = get_fields('option');

    // Nav-instellingen zitten in een ACF group 'nav' voor sub-tab UI.
    // Merge de sub-velden terug naar het root-niveau.
    if (!empty($options['nav']) && is_array($options['nav'])) {
        $options = array_merge($options, $options['nav']);
    }

    // Meldingen zitten in een ACF group 'meldingen'.
    if (!empty($options['meldingen']) && is_array($options['meldingen'])) {
        $options = array_merge($options, $options['meldingen']);
    }

    // Navigatie gedrag
    $navSticky      = !empty($options['nav_sticky']);
    $navTransparent = !empty($options['nav_transparent']);

    $logoMap = [
        'logo_1'       => 'logo',
        'logo_2'       => 'logo_white',
        'logo_3'       => 'logo_3',
        'logo_1_small' => 'logo_1_small',
        'logo_2_small' => 'logo_2_small',
        'logo_3_small' => 'logo_3_small',
    ];

    // Kleur classes voor de navigatie
    $navBgColor   = $options['menu_background_color'] ?? '';
    $navTextColor = $options['menu_text_color'] ?? 'white';

    // Gescrold staat
    $scrolledBgColor         = $options['nav_scrolled_bg_color'] ?: $navBgColor;
    $scrolledTextColor       = $options['nav_scrolled_text_color'] ?: $navTextColor;
    $scrolledLogoKey         = $options['nav_scrolled_logo'] ?: ($options['navigation_logo'] ?? 'logo_1');
    $scrolledActiveTextColor = $options['nav_scrolled_active_text_color'] ?? '';

    // CSS klassen voor de nav wrapper
    $navClasses = ['main-navigation', 'main-navigation-bar'];
    if ($navSticky) {
        $navClasses[] = 'nav-is-sticky';
    }
    if (!empty($scrolledActiveTextColor)) {
        $navClasses[] = 'has-nav-active-scrolled';
    }
    if ($navTransparent) {
        $navClasses[] = 'nav-transparent';
        $navClasses[] = 'text-' . str_replace('-color', '', $navTextColor);
    } else {
        $navClasses[] = 'bg-' . $navBgColor;
        $navClasses[] = 'text-' . str_replace('-color', '', $navTextColor);
    }

    // Body classes
    $bodyExtraClasses = [];
    if ($navTransparent) $bodyExtraClasses[] = 'has-transparent-nav';
    if ($navSticky)      $bodyExtraClasses[] = 'has-sticky-nav';
@endphp

<!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    @head
    @if(isset($options['header_codes']) && $options['header_codes'])
        {!! $options['header_codes'] !!}
    @endif
</head>
<body @php(body_class(implode(' ', $bodyExtraClasses)))>
@if(isset($options['body_codes']) && $options['body_codes'])
    {!! $options['body_codes'] !!}
@endif
<div id="page" class="site">
    <header id="masthead">
            @if (isset($options['show_secondary_menu']) && $options['show_secondary_menu'])
               @include('components.navigation.secondary-nav')
            @endif

            <div class="{{ implode(' ', $navClasses) }}"
                 data-nav-transparent="{{ $navTransparent ? 'true' : 'false' }}"
                 data-nav-sticky="{{ $navSticky ? 'true' : 'false' }}"
                 data-bg-default="bg-{{ $navBgColor }}"
                 data-bg-scrolled="bg-{{ $scrolledBgColor }}"
                 data-text-default="text-{{ str_replace('-color', '', $navTextColor) }}"
                 data-text-scrolled="text-{{ str_replace('-color', '', $scrolledTextColor) }}"
                 data-active-text-default="{{ !empty($options['menu_active_text_color']) ? 'text-' . str_replace('-color', '', $options['menu_active_text_color']) : '' }}"
                 data-active-text-scrolled="{{ !empty($scrolledActiveTextColor) ? 'text-' . str_replace('-color', '', $scrolledActiveTextColor) : '' }}"
                 data-logo-scrolled="{{ $scrolledLogoKey }}"
                 data-logo-default="{{ $options['navigation_logo'] ?? 'logo_1' }}">

                <div class="nav-container flex flex-row container mx-auto py-3 px-4">
                    <div class="logo hidden xl:flex w-1/6 items-center">
                        @include('components.header.logo')
                    </div>
                    <div class="navigation-custom-styling xl:w-5/6 flex items-center justify-end h-16 xl:h-auto">
                        @include('components.navigation.main-nav')
                        @include('components.navigation.header-mobile')
                    </div>
                </div>
            </div>
    </header>

    <div id="content" class="">
        <div id="primary">
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div><!-- #content -->
    <footer id="colophon" class="site-footer">
        @include('components.footer.footer')
    </footer><!-- #colophon -->

    @include('components.back-to-top')
</div><!-- #page -->

{!! styleCustomizer()->renderCustomColors() !!}

@footer

@if(isset($options['footer_codes']) && $options['footer_codes'])
    {!! $options['footer_codes'] !!}
@endif
</body>
</html>
