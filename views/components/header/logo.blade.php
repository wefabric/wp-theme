@php
    $logoKey = 'logo';
    if(isset($type)) {
		$logoKey .= '_'.$type;
    }
@endphp
<div class="py-4">
    @if(is_front_page() && is_home())
        <h1 class="site-title">
            <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if(isset(get_field('common', 'option')[$logoKey]) && $logoId = get_field('common', 'option')[$logoKey])
                    {!! wp_get_attachment_image( $logoId , 'header_logo', false, ['class' => '']) !!}
                @endif
                <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
            </a>
        </h1>
    @else
        <div class="site-title">
            <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if(isset(get_field('common', 'option')[$logoKey]) && $logoId = get_field('common', 'option')[$logoKey])
                    {!! wp_get_attachment_image( $logoId , 'header_logo', false, ['class' => 'w-full']) !!}
                @endif
                <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
            </a>
        </div>
    @endif
</div>
