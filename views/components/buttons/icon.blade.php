@include('components.link.opening', [
    'href' => $href,
    'alt' => $alt,
    'rel' => $rel ?? '',
    'target' => $target ?? '',
    'class' => ($a_class ?? ''). ' no-underline', // because we have an icon that is hoverable
	'attributes' => ($attributes ?? ''),
])

@php
    if(!isset($size)) {
	    $size = 'h-12 w-12 lg:h-14 lg:w-14 pt-1.5 lg:pt-2.5 mb-3 mr-3';
    }

    if(!isset($colors)) {
		$colors = 'btn-white btn-filled text-black hover:text-white';
    }
@endphp

    <span class="icon inline-block rounded-full text-center {{ $size }} {{ $colors }} {{ $class ?? '' }}">
		@if(isset($label_for))
			<label for="{{ $label_for }}" class="{{ $label_class ?? '' }}">
		@endif
		
        <i class="{{ $icon }}"></i>
        <span class="screen-reader-only">{{ $alt }}</span>

        @if(!empty($smallIconClass) && isset($smallIconContent) && $smallIconContent !== '')
            <span class="{{ $smallIconClass }}">
                {{ $smallIconContent }}
            </span>

        @endif
				
		@if(isset($label_for))
			</label>
		@endif
    </span>
@include('components.link.closing')