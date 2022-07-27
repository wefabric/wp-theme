@include('components.link.opening', [
    'href' => $href,
    'alt' => $alt,
    'rel' => $rel ?? '',
    'target' => $target ?? '',
    'class' => $a_class ?? '',
])

@php
    if(!isset($size)) {
	    $size = 'h-12 w-12 lg:h-14 lg:w-14 pt-1.5 lg:pt-2.5';
    }

    if(!isset($colors)) {
		$colors = 'bg-white hover:bg-primary-dark text-black hover:text-white';
    }
@endphp

    <span class="inline-block rounded-full mr-3 text-center {{ $size }} {{ $colors }} {{ $class ?? '' }}">
        <i class="{{ $icon }} text-xl"></i>
        <span class="screen-reader-only">{{ $alt }}</span>

        @if(!empty($smallIconClass) && isset($smallIconContent) && $smallIconContent !== '')
            <span class="{{ $smallIconClass }}">
                {{ $smallIconContent }}
            </span>

        @endif
    </span>
@include('components.link.closing')