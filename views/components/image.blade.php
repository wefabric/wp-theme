<div class="image w-full h-full object-cover {{ $class ?? '' }}">
    {!! wp_get_attachment_image($image_id, $size ?? 'full', 'false') !!}
</div>
