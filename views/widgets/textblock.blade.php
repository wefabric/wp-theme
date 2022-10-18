@php

	$bg_color = ($instance['bg_color'] ?? '') <> '' ? 'bg-'. $instance['bg_color'] : '';
	$title_color = ($instance['title_color'] ?? '') <> '' ? 'text-'. $instance['title_color'] : '';
	
@endphp

<div class="widget-content {{ $bg_color }} {{ $title_color }} flex flex-col justify-items-center">
	
	@if(!empty($instance['title']))
		@include('components.headings.normal', [
			'heading' => $instance['title'],
			'type' => 'h4',
			'title_align' => 'center',
		])
	@endif
	
	@include('components.content', [
		'content' => "Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim.",
		'class' => 'text-center pb-8',
	])
	
	@include('components.buttons.default', [
		'href' => '/contact',
		'text' => 'Meer informatie',
		'a_class' => 'px-4',
		'colors' => 'btn-white text-black'
	])
</div>