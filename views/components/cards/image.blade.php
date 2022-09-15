@php

    if($img_size === 'full') {
        $height = 'h-[600px]';
    } else {
	    foreach(config('wp-support.image_sizes') as $key => $size_config) {
			if(empty($size_config)) { $size_config = $key; }
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

    if(empty($title) && !empty($item->get('title'))) {
        $title = $item->get('title');
    }
@endphp

<div class="">
	{{-- If a link has been supplied, always display it over the image as well as any buttons. --}}
	@if(!empty($href) && !empty($title))
		@include('components.link.opening', [
			'href' => $href,
			'alt' => $alt ?? $title,
			'rel' => $rel ?? '',
			'target' => $target ?? '',
			'class' => $a_class ?? '',
		])
	@endif
	
		<div class="{{ $height }} {{ $card_classes ?? '' }} flex items-center justify-center relative {{ $image_class ?? 'bg-cover bg-center' }} bg-no-repeat w-[{{ $size_config ? $size_config['width'] : '200' }}px] "
			style="background-image: url('{{ wp_get_attachment_image_url($item->get('image'), $img_size) }}')">
		
			@if($img_size !== 'logo-slider') {{-- If logo-slider, that means this image is part of a logo-slider, then only show the image and no button. --}}
				<div class="w-full h-full mx-0.5 font-bold text-3xl">
					{{ $item->get('title') }}
				</div>
				
				<div class="absolute bottom-5 lg:right-5">
					@include('components.buttons.default', [
						'button' => $item,
						'colors' => 'btn-primary-light hover:btn-primary-dark text-white disable-chevron',
					])
				</div>
			@endif
		
		</div>
	
	@if(!empty($href) && !empty($title))
		@include('components.link.closing')
	@endif
</div>
