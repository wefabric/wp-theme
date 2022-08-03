<div class="container mx-auto">
    @include('components.headings.normal', [
	    'type' => 2,
	    'heading' => $block->get('title'),
    ])

    @include('components.content', [
        'content' => $block->get('content'),
    ])

    <div class="mt-3">
        {!! $block->get('form') !!}
    </div>
</div>