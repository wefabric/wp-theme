@include('components.link.opening', [
	'href' => $href,
	'alt' => $alt ?? $text,
	'class' => $class ?? '',
	'rel' => $rel ?? '',
	'target' => $target ?? ''
])
    {{ $text }}
@include('components.link.closing')