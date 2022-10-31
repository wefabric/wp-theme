@php

    if(!empty($size_config)) { // $size_config has been selected at gallery/index.blade.php already.
		$height = 'h-['. $size_config['height'] .'px]';
		if(array_key_exists('mobile_height', $size_config) && $size_config['mobile_height']) {
			$height = 'h-['. $size_config['mobile_height'] .'px] lg:'. $height;
		}
		
		if(array_key_exists('relative', $size_config) && $size_config['relative']) {
			$width = 'w-full'; //relative to the grid, simply take all the given space.
		} else {
			$width = 'w-['. $size_config['width'] .'px]'; // ' lg:w-['. $size_config['width'] .'px]'
		}
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

<div class="">
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
	
		<div class="image {{ $height }} {{ $width }} {{ $card_classes ?? '' }} flex flex-col items-center justify-center relative {{ $image_class ?? 'bg-cover bg-center' }} bg-no-repeat {{ $rounded ? '' : 'disable-rounded' }}"
			style="background-image: url('{{ wp_get_attachment_image_url($item->get('image'), $img_size) }}')">
			
			@if($item->get('shadow') > 0)
				<div class="bg-black opacity-{{ $item->get('shadow') }} z-1 absolute h-full w-full top-0 left-0"></div> {{-- black shade over image. --}}
			@endif
	
			@if($img_size !== 'logo-slider') {{-- If logo-slider, that means this image is part of a logo-slider, then only show the image and no button. --}}
				{{-- TODO fix: add style choices --}}
				<div class="z-2 w-3/4 h-1/2 pb-3 lg:pb-5 h1 lg:h3 text-center flex items-end">
					{{ $item->get('title') }}
				</div>
				
				<div class="z-2 h-1/2 pt-3 lg:pt-5">
					@include('components.buttons.default', [
						'button' => $item,
						'class' => 'btn-white text-black',
 					])
				</div>
			@endif
		
		</div>
	
	@if($img_size === 'logo-slider' && !empty($href) && !empty($title))
		@include('components.link.closing')
	@endif
</div>
