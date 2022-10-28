@php
    $title = $block->get('title');
	$buttons = $block->get('buttons');
	$columns = $block->get('col_amount');
@endphp

<div class="">
	
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
		])
	@endif
	
	{{-- TODO add styling choice for USP texts. --}}
	
    @include('components.slider.smart-slider', [
        'items' => $block->get('usps'),
        'card_type' => 'usp',
		
		'slider_on_items' => $columns,
		'breakPoints' => [
			768 => [ // md:
				'slidesPerView' => $columns,
			],
		],
		
		'grid_class' => 'flex justify-center',
        'grid_items_class' => 'w-1/4',
		
        'size' => $block->get('icon_size'),
        'position' => $block->get('position'),
        'icon_color' => $block->get('icon_color'),
        'align' => $block->get('align')
    ])

	@if($buttons->get('show_button'))
		<div class="flex pt-6 lg:pt-10 justify-{{ $buttons->get('justify') }}">
			@foreach($buttons->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4 no-underline',
				])
			@endforeach
		</div>
	@endif

</div>