@php

	$bg_color = ($instance['bg_color'] ?? '') <> '' ? 'bg-'. $instance['bg_color'] : '';
	$title_color = ($instance['title_color'] ?? '') <> '' ? 'text-'. $instance['title_color'] : '';

@endphp

<div class="widget-content {{ $bg_color }} {{ $title_color }} flex flex-col text-center p-4 lg:p-0 lg:mb-0">
	
	@if(!empty($instance['title']))
		@include('components.headings.normal', [
			'heading' => $instance['title'],
			'type' => 'h3',
            'class' => 'pb-4',
			'title_align' => 'center',
		])
	@endif
	
	@include('components.content', [
		'content' => $instance['text'],
		'class' => 'text-center pb-8',
	])
	
	@include('components.buttons.default', [
		'href' =>	$instance['button_link'],
		'text' => $instance['button_text'],
		'a_class' => 'px-4',
		'colors' => 'btn-'.  $instance['button_color'].' text-'. $instance['button_text_color']
	])
</div>