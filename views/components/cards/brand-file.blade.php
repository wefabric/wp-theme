@php
	if(!isset($brand_file)) {
		$brand_file = $item;
	}
@endphp

<div class="card bg-white p-8 flex flex-col justify-center">
	@include('components.image', [
		'image_id' => $item['image'],
		'size' => 'brand_logo',
		'class' => ' mx-auto h-[200px]',
		'img_class' => 'bg-center bg-no-repeat',
	])
	
	<div class="h5 py-5 text-center">
		{{ $item['name'] }}
	</div>
	
	@include('components.buttons.default', [
		'href' => empty($item['file']) ? '#' : wp_get_attachment_url($item['file']),
		'text' => 'Download '. $item['type'],
		'colors' => 'bg-gray-100 text-black',
		'a_class' => 'self-center ',
	])
</div>