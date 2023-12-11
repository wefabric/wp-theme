@php
	if(!isset($review)) {
		$review = $item;
	}

	$theme = app('wp.theme');
@endphp
<div class="w-full h-full flex justify-center">
	<img src="{{ $theme->getUrl('assets/images/' . $review['file']) }}" class="" alt="" style=""/>
</div>

