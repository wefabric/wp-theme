<div class="container mx-auto {{ $class ?? '' }} w-full lg:{{ $block->get('width') }}">
    @include('components.iframe.html', [
		'html' => $block->get('iframe-html'),
	])
</div>

