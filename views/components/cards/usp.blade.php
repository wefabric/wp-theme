@php
	$flexDir = match($position ?? 'left') {
		'above' => 'flex-col',
		default => 'flex-row', //left
	};
	
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

<div class="flex {{ $flexDir }} justify-center items-center">
	@if(! empty($link))
		@include('components.link.opening', [
			'href' => $link,
			'alt' => $item->get('title'),
		])
	@endif
	
		<div class="">
			@if(!empty($item->get('image')))
				@include('components.image', [
					'image_id' => $item->get('image'),
					'size' => 'usp-icon',
				])
			@elseif(!empty($item->get('icon')))
				<span class="text-{{ $size ?? '2xl' }} {{ $item->get('icon') }} text-{{ $icon_color ?? 'black' }}"></span>
			@endif
		</div>

		<div class="flex flex-col px-5">
			<span class="block text-base font-normal">
				{{ $item->get('title') }}
			</span>
		</div>

	@if(! empty($link))
		@include('components.link.closing')
	@endif
</div>
