<div class="card bg-white px-4 py-12">
	@include('components.link.opening', [
		'href' => get_category_link($item->term_taxonomy_id),
		'alt' => $item->name,
		'class' => 'h-full block'
	])

		@include('components.image', [
			'image_id' => get_term_meta($item->term_taxonomy_id, 'thumbnail_id', true),
			'size' => 'brand_logo',
			'class' => 'block h-[200px] disable-rounded align-center flex',
			'img_class' => 'mx-auto bg-center bg-no-repeat block self-center',
		])
	
		<h3 class="block h5 text-center">
			{{ $item->name }}
		</h3>
	
	@include('components.link.closing')
</div>