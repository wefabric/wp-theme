<div>
    @if(is_front_page() && is_home())
        <h1 class="site-title">
            <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
                    {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => '']) !!}
                @endif
                <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
            </a>
        </h1>
    @else
        <div class="site-title">
            <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
                    {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'w-full']) !!}
                @endif
                <span class="screen-reader-only">{{ get_bloginfo('name') }}</span>
            </a>
        </div>
    @endif
</div>
