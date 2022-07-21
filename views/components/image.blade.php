<div class="image w-full h-full {{ $class ?? '' }}">
    {!!
        wp_get_attachment_image($image_id, $size ?? 'full', 'false', [
	        'class' => 'object-'. ($object_fit ?? 'cover') .' '. ($img_class ?? ''). ' ',
        ])
    !!}
</div>
