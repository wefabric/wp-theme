@php
    $title = $block->get('title');
	$buttons = $block->get('buttons');
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
	
	@if($title->get('show_separate_title'))
		@include('components.headings.normal', [
			'type' => 2,
	        'class' => 'font-bold text-2xl py-2',
            'title' => $title,
    	])
	@endif
	
    @include('components.slider.smart-slider', [
        'items' => $block->get('usps'),
        'card_type' => 'usp',
        'slider_on_items' => 3,
        'loop' => false,
        'pagination' => true,
        'prevNext' => false,
		
        'size' => $block->get('icon_size'),
        'position' => $block->get('position'),
        'icon_color' => $block->get('icon_color'),
    ])

	@if($buttons->get('show_button'))
		<div class="flex pt-6 justify-{{ $buttons->get('justify') }}">
			@foreach($buttons->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4 no-underline',
				])
			@endforeach
		</div>
	@endif

</div>