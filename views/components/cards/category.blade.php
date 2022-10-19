<div class="card bg-white px-4 py-12 flex justify-center">
	@include('components.link.opening', [
		'href' => '#',
		'alt' => $item['title'],
		'a_class' => 'flex h-full justify-center'
	])

		@include('components.image', [
			'image_id' => $item['image'],
			'size' => 'brand_logo',
			'class' => 'block h-4/5 max-h-[200px] disable-rounded align-center',
			'img_class' => 'mx-auto bg-center bg-no-repeat',
		])
	
		<span class="block h5 h-1/5 text-center mt-8">
			{{ $item['title'] }}
		</span>
	
	@include('components.link.closing')
</div>