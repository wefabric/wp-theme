@php

	$bg_color = ($instance['bg_color'] ?? '') <> '' ? 'bg-'. $instance['bg_color'] : '';
	$title_color = ($instance['title_color'] ?? '') <> '' ? 'text-'. $instance['title_color'] : '';
	$icon_color = ($instance['icon_color'] ?? '') <> '' ? 'text-'. $instance['icon_color'] : '';
	
	$usps = [];
	for($i=0; $i<\App\Widgets\USPsWidget::max_icons; $i++) {
		$usp = [];
		
		$usp['title'] = $instance['usp_text_'. $i] ?? '';
		$usp['icon'] = $instance['usp_icon_'. $i] ?? '';

		if(!empty($usp['title']) && !empty($usp['icon'])) {
			$usps[] = $usp;
		}
	}
	
	$breakpoints = [
		1 => [
			'slidesPerView' => 1,
		],
	];
@endphp

<div class="widget-content {{ $bg_color }} {{ $title_color }}">
	
	@if(!empty($instance['title']))
		@include('components.headings.normal', [
			'heading' => $instance['title'],
			'type' => 'h3',
			'title_align' => 'center',
			'class' => 'pb-4',
		])
	@endif

	{{-- TODO dit blok neemt teveel breedte in --}}
	@include('components.slider.smart-slider', [
		'items' => $usps,
		'card_type' => 'usp',
		'slider_on_items' => 1,
		'breakPoints' => $breakpoints,

		'position' => 'above',
		'align' => 'center', //TODO fix
		'text_align' => 'text-center',
		'icon_color' => $icon_color,
		'display' => 'inline-block',
		'size' => '4xl',
		'style' => 'h4'
	])

</div>