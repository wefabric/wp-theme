<div class="{{ $class ?? '' }}">
	@include('components.iframe.url', [
		'src' => $block->get('iframe-url'),
		'height' => $block->get('height_desktop'),
		'title' => $block->get('description'),
	])
</div>
