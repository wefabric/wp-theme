<div class="footer-logos-section flex flex-wrap gap-6 items-center">
    @foreach($logos as $item)
        @php
            $imageId = $item['image'] ?? null;
            $logoLink = $item['url'] ?? null;
            $logoUrl = $logoLink['url'] ?? '';
            $logoTarget = $logoLink['target'] ?? '_self';
        @endphp
        @if($imageId)
            <div class="footer-logo-item">
                @if($logoUrl)
                    <a href="{{ esc_url($logoUrl) }}" target="{{ $logoTarget }}" @if($logoTarget === '_blank') rel="noopener noreferrer" @endif aria-label="{{ !empty($logoLink['title']) ? $logoLink['title'] : (get_post_meta($imageId, '_wp_attachment_image_alt', true) ?: parse_url($logoUrl, PHP_URL_HOST)) }}">
                @endif
                {!! wp_get_attachment_image($imageId, 'medium', false, ['class' => 'footer-logo-img', 'loading' => 'lazy']) !!}
                @if($logoUrl)
                    </a>
                @endif
            </div>
        @endif
    @endforeach
</div>

