@php
    $options = get_fields('option');

    // Nav-instellingen zitten in ACF group 'nav' — merge terug naar root niveau
    if (!empty($options['nav']) && is_array($options['nav'])) {
        $options = array_merge($options, $options['nav']);
    }

    $logoMap = [
        'logo_1'       => 'logo',
        'logo_2'       => 'logo_white',
        'logo_3'       => 'logo_3',
        'logo_1_small' => 'logo_1_small',
        'logo_2_small' => 'logo_2_small',
        'logo_3_small' => 'logo_3_small',
    ];

    $navTransparent  = !empty($options['nav_transparent']);
    $commonFields    = get_field('common', 'option') ?? [];

    // Standaard logo — wordt altijd getoond (en in transparante staat vóór scrollen)
    $defaultLogoKey = $logoMap[$options['navigation_logo'] ?? 'logo_1'] ?? 'logo';
    $defaultLogoId  = $commonFields[$defaultLogoKey] ?? 0;

    // Gescrold logo (na scrollen) — render zodra er expliciet een logo is geselecteerd
    $scrolledLogoRaw = $options['nav_scrolled_logo'] ?? '';
    $scrolledLogoKey = !empty($scrolledLogoRaw) ? ($logoMap[$scrolledLogoRaw] ?? '') : '';
    $scrolledLogoId  = $scrolledLogoKey ? ($commonFields[$scrolledLogoKey] ?? 0) : 0;
@endphp

<div class="site-title">
    <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">

        {{-- Default logo: zichtbaar normaal (en na scrollen als er geen scrolled logo is) --}}
        @if($defaultLogoId)
            <div class="logo-img logo-img--default">
                {!! wp_get_attachment_image($defaultLogoId, 'header_logo', false, ['class' => 'w-full']) !!}
            </div>
        @endif

        {{-- In transparante modus: het standaard logo is ook het transparante logo. --}}
        {{-- CSS (via .nav-transparent) regelt de zichtbaarheid via logo-img--default. --}}
        {{-- Geen apart transparant logo-element nodig. --}}

        {{-- Gescrold logo: zichtbaar na scrollen als een logo is geselecteerd --}}
        @if($scrolledLogoId)
            <div class="logo-img logo-img--scrolled">
                {!! wp_get_attachment_image($scrolledLogoId, 'header_logo', false, ['class' => 'w-full']) !!}
            </div>
        @endif

        <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
    </a>
</div>
