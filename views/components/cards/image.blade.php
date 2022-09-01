@php

    if($img_size === 'full') {
        $height = 'h-[600px]';
    } else {
	    foreach(config('wp-support.image_sizes') as $key => $size_config) {
		    if($size_config['name'] === $img_size) {
				$config = $size_config['height'];
				break;
		    }
	    }
		if(empty($config)) {
			$config = 600;
		}

        $height = 'h-['. $config .'px] lg:h-['. $config .'px]';
    }

    if(empty($href) && (!empty($item->get('external_link')) || !empty($item->get('internal_link')))) {
        $href = empty($item->get('external_link')) ? $item->get('internal_link') : $item->get('external_link');
    }

    if(empty($text) && !empty($item->get('title'))) {
        $text = $item->get('title');
    }
@endphp

{{-- If a link has been supplied, always display it over the image as well as any buttons. --}}
@if(!empty($href) && !empty($text))
    @include('components.link.opening', [
        'href' => $href,
        'alt' => $alt ?? $text,
        'rel' => $rel ?? '',
        'target' => $target ?? '',
        'class' => $a_class ?? '',
    ])
@endif

<div class="{{ $height }} {{ $card_classes ?? '' }} flex items-center justify-center relative {{ $image_class ?? 'bg-cover bg-center' }} bg-no-repeat w-[{{ $size_config ? $size_config['width'] : '200' }}px] "
    style="background-image: url('{{ wp_get_attachment_image_url($item->get('image'), $img_size) }}')">

@if($img_size !== 'header_logo') {{-- If header logo, that means this is part of a logo-slider, then only show the image and no button. --}}
    <div class="w-full h-full mx-0.5">
        <div class="font-bold text-3xl">
            {{ $item->get('title') }}
        </div>

        <div class="absolute bottom-5 lg:right-5">
            @include('components.buttons.default', [
                'button' => $item,
                'colors' => 'btn-primary-light hover:btn-primary-dark text-white disable-chevron',
            ])
        </div>

    </div>
@endif

</div>

@if(!empty($href) && !empty($text))
    @include('components.link.closing')
@endif
