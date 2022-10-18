<div class="container mx-auto  {{ $class ?? '' }} w-full lg:{{ $block->get('width') }}  ">
	@include('components.iframe.url', [
		'src' => $block->get('iframe-url'),
		'height' => $block->get('height_desktop'),
		'title' => $block->get('description'),
	])
</div>
