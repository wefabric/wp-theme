@php
    $title = $block->get('title');
    $subtitle = $block->get('subtitle');
	$usps = $block->get('usps');

	$size = $block->get('icon_size');
    $position = $block->get('position');
	$color = $block->get('icon_color');
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">

    @if(!empty($title))
        @include('components.headings.normal', [
            'type' => '2',
            'class' => 'font-bold text-2xl py-2',
            'heading' => $title,
        ])
    @endif

    @if(!empty($subtitle))
        @include('components.headings.normal', [
            'type' => '3',
            'class' => 'font-bold text-xl py-4',
            'heading' => $subtitle,
        ])
    @endif

    @include('components.slider.smart-slider', [
        'items' => $usps,
        'card_type' => 'usp',
        'slider_on_items' => 3,
        'loop' => false,
        'size' => $size,
        'position' => $position,
        'icon_color' => $color,
        'pagination' => true,
        'prevNext' => false
    ])

    @if(!empty($block->get('button')))
        @include('components.buttons.default', [
            'button' => $block->get('button'),
            'colors' => 'btn-primary-light hover:btn-primary-dark text-white disable-chevron',
        ])
    @endif

</div>