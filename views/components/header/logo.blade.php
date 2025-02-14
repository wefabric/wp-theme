@php
    $options = get_fields('option');
    $logoToDisplay = '';

    if (isset($options['navigation_logo']) && $options['navigation_logo'] === 'logo_2') {
        $logoToDisplay = 'logo_white';
    } else {
        $logoToDisplay = 'logo';
    }
@endphp


<div class="site-title">
    <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
        @if(isset(get_field('common', 'option')[$logoToDisplay]) && $logoId = get_field('common', 'option')[$logoToDisplay])
            {!! wp_get_attachment_image($logoId, 'header_logo', false, ['class' => 'w-full']) !!}
        @endif
        <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
    </a>
</div>
