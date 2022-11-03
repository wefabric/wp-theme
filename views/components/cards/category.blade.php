<div class="card bg-white px-4 py-12 flex justify-center">
	@include('components.link.opening', [
		'href' => get_category_link($item->term_taxonomy_id),
		'alt' => $item->name,
		'a_class' => 'flex justify-center'
	])

		@include('components.image', [
			'image_id' => get_term_meta($item->term_taxonomy_id, 'thumbnail_id', true),
			'size' => 'brand_logo',
			'class' => 'block h-4/5 max-h-[200px] disable-rounded align-center',
			'img_class' => 'mx-auto bg-center bg-no-repeat',
		])
	
		<span class="block h5 text-center mt-8">
			{{ $item->name }}
		</span>
	
	@include('components.link.closing')
</div>