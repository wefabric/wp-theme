<div class="footer-logos-section flex flex-wrap gap-6 items-center">
    @foreach($logos as $item)
        @php $imageId = $item['image'] ?? null; @endphp
        @if($imageId)
            <div class="footer-logo-item">
                {!! wp_get_attachment_image($imageId, 'medium', false, ['class' => 'footer-logo-img', 'loading' => 'lazy']) !!}
            </div>
        @endif
    @endforeach
</div>

