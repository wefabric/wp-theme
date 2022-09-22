@php

    if(!empty($size_config)) { // $size_config has been selected at gallery/index.blade.php already.
        $height = 'h-['. $size_config['height'] .'px] lg:h-['. $size_config['height'] .'px]';
        $width = 'w-['. $size_config['width'] .'px] lg:w-['. $size_config['width'] .'px]';
    } else {
        $height = 'h-[600px]';
		$width = 'w-[200px]';
    }

    if(empty($href) && (!empty($item->get('external_link')) || !empty($item->get('internal_link')))) {
        $href = empty($item->get('external_link')) ? $item->get('internal_link') : $item->get('external_link');
    }

    if(empty($title) && !empty($item->get('title'))) {
        $title = $item->get('title');
    }
@endphp

<div class="relative">
	{{-- If a link has been supplied, only display it over the image in case of logo slider, which automatically doesn't contain a button. --}}
	@if($img_size === 'logo-slider' && !empty($href) && !empty($title))
		@include('components.link.opening', [
			'href' => $href,
			'alt' => $alt ?? $title,
			'rel' => $rel ?? '',
			'target' => $target ?? '',
			'class' => $a_class ?? '',
		])
	@endif
	
		<div class="image {{ $height }} {{ $width }} {{ $card_classes ?? '' }} flex items-center justify-center relative {{ $image_class ?? 'bg-cover bg-center' }} bg-no-repeat"
			style="background-image: url('{{ wp_get_attachment_image_url($item->get('image'), $img_size) }}')">
		
			@if($img_size !== 'logo-slider') {{-- If logo-slider, that means this image is part of a logo-slider, then only show the image and no button. --}}
				<div class="w-full h-full mx-0.5 font-bold text-3xl">
					{{ $item->get('title') }}
				</div>
				
				<div class="absolute bottom-5 lg:right-5">
					@include('components.buttons.default', [
						'button' => $item,
//						'colors' => 'btn-primary-light hover:btn-primary-dark text-white',
					])
				</div>
			@endif
		
		</div>
	
	@if($img_size === 'logo-slider' && !empty($href) && !empty($title))
		@include('components.link.closing')
	@endif
</div>
