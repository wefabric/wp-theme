@php
	$card_classes = '';
	$count = count($block->get('photos'));
	$columns = $block->get('display_columns');
	$img_size = 'gallery-thumbnail-1/'. $columns;
	
	switch($block->get('display_type')) {
//		case 'grid': break;
		case 'logo-slider':
			$img_size = 'logo-slider';
			// no break;
		case 'slider':
			$image_class = 'bg-contain bg-center';
			$spaceBetween = $block->get('width') === 'nomargin' ? 0 : 30;
			
			$standard = [
				'spaceBetween' => $spaceBetween,
				'centeredSlides' => true,
				'autoplay' => [
					'delay' => 2500,
					'disableOnInteraction' => false,
				],
			];
			$breakPoints = [
				1 => array_merge($standard, [ //mobile
					'slidesPerView' => 1,
				]),
				640 => array_merge($standard, [ //small tablet
					'slidesPerView' => (int) min($count, $columns, 2),
				]),
				768 => array_merge($standard, [ //larger tablet, or small laptop
					'slidesPerView' => (int) min($count, $columns, 3),
				]),
				1024 => array_merge($standard, [ //most self-respecting laptops
					'slidesPerView' => (int) min($count, $columns, 5), // 'auto'
				]),
			];
			break;
	}

	foreach(config('wp-support.image_sizes') as $key => $image_size_config) {
		if($image_size_config['name'] == $img_size) {
			$size_config = $image_size_config; //found the base config. but keep looking just in case.
		} elseif ($block->get('width') === 'nomargin' && $image_size_config['name'] == $img_size .'-nomargin') {
			$size_config = $image_size_config;
			$img_size .= '-nomargin';
			break; //found the exact config.
		}
	}
	
	if($block->get('width') !== 'nomargin') {
		$card_classes .= ' m-0';
		$grid_class = 'gap-4';
	}
@endphp

<div class="@if($block->get('width') !== 'nomargin') container @endif mx-auto w-full lg:{{ $block->get('width') === 'nomargin' ? 'w-full' : $block->get('width') }} ">
	
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
		])
	@endif

	@if($block->get('display_type') !== 'grid')
		@include('components.slider.smart-slider', [
			'items' => $block->get('photos'),
			'card_type' => 'image',
			'breakPoints' => $breakPoints ?? [],
			'card_classes' => ($card_classes ?? ''),

			'image_class' => $image_class ?? '',
			'img_size' => $img_size ?? 'full',
			'size_config' => $size_config,
		])
	@else
		@include('components.slider.grid', [
			'items' => $block->get('photos'),
			'card_type' => 'image',
			'grid_class' => 'lg:grid-cols-'. $columns .' '. ($card_classes ?? '') .' '. ($grid_class ?? ''),

			'img_size' => $img_size ?? 'full',
			'size_config' => $size_config,
			'rounded' => $block->get('width') !== 'nomargin',
		])
	@endif

	@if($block->get('buttons')->get('show_button'))
		<div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
			@foreach($block->get('buttons')->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4',
				])
			@endforeach
		</div>
	@endif

</div>