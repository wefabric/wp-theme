<div>
    @if(is_front_page() && is_home())
        <h1 class="site-title">
            <a href="{{ esc_url(home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if($logoId = get_field('common', 'option')['logo'])
                    {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => '']) !!}
                @endif
            </a>
        </h1>
    @else
        <p class="site-title">
            <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
                @if($logoId = get_field('common', 'option')['logo'])
                    {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'w-full']) !!}
                @endif
            </a>
        </p>
    @endif
</div>