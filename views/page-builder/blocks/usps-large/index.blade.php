<div class=>

    <div class="font-bold text-2xl py-2">
        {{ $block->get('title') }}
    </div>

    <div class="font-bold text-xl py-4">
        {{ $block->get('subtitle') }}
    </div>

    @include('components.slider.smart-slider', [
	    'items' => $block->get('usps'),
        'card_type' => 'usp-large',
    ])

</div>
