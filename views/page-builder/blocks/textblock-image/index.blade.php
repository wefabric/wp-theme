@php
	/* bool */ $overlap = (($block->get('text_width') + $block->get('image_width')) > 100); //more than 100% selected -> overlapping text and image
	
	switch ($block->get('text_width')) {
		case 25 : $text_width = 'w-1/4'; break;
		case 33 : $text_width = 'w-1/3'; break;
		case 40 : $text_width = 'w-2/5'; break;
		case 50 : $text_width = 'w-1/2'; break;
		case 60 : $text_width = 'w-3/5'; break;
		case 66 : $text_width = 'w-2/3'; break;
		case 75 : $text_width = 'w-3/4'; break;
	}
	
	switch ($block->get('image_width')) {
		case 25 : $image_width = 'w-1/4'; break;
		case 33 : $image_width = 'w-1/3'; break;
		case 40 : $image_width = 'w-2/5'; break;
		case 50 : $image_width = 'w-1/2'; break;
		case 60 : $image_width = 'w-3/5'; break;
		case 66 : $image_width = 'w-2/3'; break;
		case 75 : $image_width = 'w-3/4'; break;
	}
	
	$image = $block->get('image');

	if($overlap) {
		switch($image->get('height_desktop')) {
			case '500px': $text_padding = 'lg:pt-20'; break;
			case '600px': $text_padding = 'lg:pt-24'; break;
			case '700px': $text_padding = 'lg:pt-28'; break;
			case '800px': $text_padding = 'lg:pt-32'; break;
			case '900px': $text_padding = 'lg:pt-36'; break;
		}
	}
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }} @if($overlap) lg:h-[{{ $image->get('height_desktop') }}] relative @else lg:flex @endif ">
	
	@if($overlap)
		<div class="flex lg:absolute z-10 w-full lg:{{ $image_width }} h-[400px] lg:h-full bg-no-repeat bg-contain bg-center @if($image->get('position') == 'right') lg:order-2 lg:bg-right lg:right-0 @else lg:bg-left @endif"
			 style="background-image: url('{{ wp_get_attachment_image_url($image->get('image'), 'textblock-image') }}')">
		</div>
	@else
		<div class="w-full lg:{{ $image_width }} py-8 lg:py-0 @if($image->get('position') == 'right') lg:order-3 @else lg:order-1 @endif @switch($image->get('vertical_position'))
				@case('middle') lg:my-auto @break
				@case('bottom') lg:mt-auto lg:mb-0 @break;
			@endswitch ">
		
			@include('components.image', [
				'image_id' => $image->get('image'),
				'class' => 'mx-auto',
				'size' => 'textblock-image',
				'img_class' => ''
			])
		</div>
		
		<div class="flex grow lg:order-2"></div>
	@endif
	
	<div class="flex pt-4 @if($overlap) {{ $text_padding }} @endif w-full lg:{{ $text_width }} @if($image->get('position') == 'right') lg:order-1 @else lg:order-3 @endif
		@switch($image->get('vertical_position')) {{-- For aligning the text,when shorter than the image. --}}
			@case('middle') lg:my-auto @break
			@case('bottom') lg:mt-auto lg:mb-0 @break;
        @endswitch ">
		
		<div class="relative flex flex-col z-50 h-full w-full @if($overlap) lg:px-16 lg:py-20 @else lg:px-5 lg:py-5 @endif text-{{ $block->get('text_color') }}">
			@if($block->get('title')->get('show_separate_title'))
				@include('components.headings.collection', [
					'title' => $block->get('title'),
				])
			@endif
			
			@include('components.content', [
				'content' => $block->get('text'),
				'class' => 'text-'. $block->get('text_align'),
			])
			
			@if($block->get('buttons')->get('show_button'))
				<div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
					@foreach($block->get('buttons')->get('buttons') as $button)
						@include('components.buttons.default', [
							'button' => $button,
							'class' => 'disable-chevron font-bold',
							'a_class' => 'px-4',
						])
					@endforeach
				</div>
			@endif
			
		</div>
	</div>
</div>