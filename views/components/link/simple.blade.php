@include('components.link.opening', [
	'href' => $href,
	'alt' => $alt ?? $text,
	'class' => $class ?? '',
	'rel' => $rel ?? '',
	'target' => $target ?? ''
])
@if($span ?? true)
	<span>{{ $text }}</span>
@else
	{{ $text }}
@endif
@include('components.link.closing')