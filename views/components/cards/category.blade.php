<div class="card bg-white p-12 flex justify-center">
	@include('components.link.opening', [
		'a_class' => 'flex justify-center'
		'href' => get_category_link($item->term_taxonomy_id),
		'alt' => $item->name,
	])
		@include('components.image', [
			'image_id' => get_term_meta($item->term_taxonomy_id, 'thumbnail_id', true),
			'size' => 'brand_logo',
			'class' => ' mx-auto h-[200px]',
			'img_class' => 'bg-center bg-no-repeat',
		])
	
		<div class="h5 text-center pt-10">
		</div>
			{{ $item->name }}
	
	@include('components.link.closing')
</div>