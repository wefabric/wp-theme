@php
	
	$class = ($instance['class'] ?? '') <> '' ? $instance['class'] : '';

	$url = ($instance['url'] ?? '') <> '' ? $instance['url'] : '';
	$height = ($instance['height'] ?? '') <> '' ? $instance['height'] : '';

	$html = ($instance['html'] ?? '') <> '' ? $instance['html'] : '';
	
@endphp

<div class="{{ $class }}">
	@if(!empty($url))
		@include('components.iframe.url', [
			'src' => $url,
			'height' => $height .'px',
			'title' => 'Sidebar iframe',
		])

	@elseif(!empty($html))
		@include('components.iframe.html', [
			'html' => $html
		])
	@endif
</div>