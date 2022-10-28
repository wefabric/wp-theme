@php
	$flexDir = match($position ?? 'left') {
		'above' => 'flex-col',
		default => 'flex-row', //left
	};
	
	if($flexDir === 'flex-col') {
		$align = 'items-'. $align;
		$px = 'px-5';
	} else {
		$align = 'items-center';
		$px = '';
	}
	
	if(is_array($item)) {
		$item = collect($item);
	}
	
	if(!empty($item->get('external_url'))) {
		$link = $item->get('external_url');
	} elseif (!empty($item->get('page_url'))) {
		$link = $item->get('page_url');
	}
	
	if(empty($icon_color) && !empty($item->get('color'))) {
		$icon_color = $item->get('color');
	}
@endphp

<div class="flex {{ $flexDir }} {{ $align }} {{ $class ?? '' }}">
	@if(! empty($link))
		@include('components.link.opening', [
			'href' => $link,
			'alt' => $item->get('title'),
		])
	@endif
	
		<div class="{{ $px }}">
			@if(!empty($item->get('image')))
				@include('components.image', [
					'image_id' => $item->get('image'),
					'size' => 'usp-icon',
				])
			@elseif(!empty($item->get('icon')))
				<span class="text-{{ $size ?? '2xl' }} {{ $item->get('icon') }} text-{{ $icon_color ?? 'black' }}"></span>
			@endif
		</div>

		<div class="flex flex-col px-5 lg:w-full {{ $text_align ?? 'text-left' }}">
			<span class="{{ $display ?? 'block' }} {{ $style ?? 'h6' }}">
				{{ $item->get('title') }}
			</span>
			
			@if(!empty($item->get('subtitle')))
				<span class="p ">
					{{ $item->get('subtitle') }}
				</span>
			@endif
		</div>

	@if(! empty($link))
		@include('components.link.closing')
	@endif
</div>
