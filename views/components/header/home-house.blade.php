@php
    $alt = 'Naar de homepagina';
@endphp

@include('components.link.opening', [
    'href' => get_home_url(),
    'class' => $a_class ?? '',
    'alt' => $alt,
])

	<i class="fa-regular fa-house text-white hover:text-secondary {{ $class ?? ''}}"></i>
	<span class="screen-reader-only">{{ $alt }}</span>

@include('components.link.closing')