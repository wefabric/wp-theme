<div class="card bg-white p-12 flex justify-center">
	@include('components.link.opening', [
		'href' => '#',
		'alt' => $item['title'],
		'a_class' => 'flex justify-center'
	])
		@include('components.image', [
			'image_id' => $item['image'],
			'size' => 'brand_logo',
			'class' => ' mx-auto h-[200px]',
			'img_class' => 'bg-center bg-no-repeat',
		])
	
		<div class="h5 text-center pt-10">
			{{ $item['title'] }}
		</div>
	
	@include('components.link.closing')
</div>