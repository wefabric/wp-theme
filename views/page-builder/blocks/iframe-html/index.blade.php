<div class="{{ $class ?? '' }}">
    @include('components.iframe.html', [
		'html' => $block->get('iframe-html'),
	])
</div>

