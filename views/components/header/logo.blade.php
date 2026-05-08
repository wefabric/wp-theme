@php
    $options = get_fields('option');
    $logoToDisplay = '';

    $logoMap = [
        'logo_1'       => 'logo',
        'logo_2'       => 'logo_white',
        'logo_3'       => 'logo_3',
        'logo_1_small' => 'logo_1_small',
        'logo_2_small' => 'logo_2_small',
        'logo_3_small' => 'logo_3_small',
    ];
    $logoToDisplay = $logoMap[$options['navigation_logo'] ?? 'logo_1'] ?? 'logo';
@endphp


<div class="site-title">
    <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
        @if(isset(get_field('common', 'option')[$logoToDisplay]) && $logoId = get_field('common', 'option')[$logoToDisplay])
            {!! wp_get_attachment_image($logoId, 'header_logo', false, ['class' => 'w-full']) !!}
        @endif
        <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
    </a>
</div>
