@php
	//header with pulled-up block, so that breadcrumbs can be displayed 'over' the header image.

	$imageId = $block->get('image') ?? get_field('common', 'option')['default_header_image'];
	$videoUrl = $block->get('video');

	$bg = '';
	$gradient = '';
	if($block->get('bg_color')) {
		if($block->get('bg_color_2')) { //gradient
			$from = color_to_rgba($block->get('bg_color'));
			$to = color_to_rgba($block->get('bg_color_2'));
			$gradient = 'background: linear-gradient(180deg, '. $from .' 0%, '. $from .' 50%, '. $to .' 50%, '. $to .' 100%);';
		} else { //solid bg.
			$bg = 'bg-'. $block->get('bg_color');
		}
	}
@endphp
<div class="header header-2 w-full relative -z-1 @if(!empty($bg)) {{ $bg }} @endif" @if(!empty($gradient)) style="{{ $gradient }}" @endif >
	<div class="image py-15 lg:pt-40 md:pb-80 mt-3 bg-center bg-cover bg-no-repeat z-50 relative" style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}')">
		<div class="bg-black opacity-20 -z-1 absolute h-full w-full top-0 left-0"></div>

		@if(!empty($video))
			<div class="hidden lg:block"> {{-- only show on desktop, to prevent data usage when on mobile--}}
				<video class="header-video" width="100%" height="100%" autoplay loop muted>
					<source src="{{ $videoUrl }}" type="video/mp4" />
					Your browser does not support HTML video.
				</video>
			</div>
		@endif

		<div class="container mx-auto w-full lg:w-3/4 py-8 lg:py-0 flex flex-col items-center text-center text-{{ $block->get('text_color') }}">

			@include('components.headings.normal', [
				'type' => 1,
				'heading' => $block->get('title'),
				'class' => 'w-4/5 xl:w-1/2 text-2xl md:text-4xl lx:text-[58px]',
			])

			@if(!empty($block->get('subtitle')))
				@include('components.headings.normal', [
					'type' => 2,
					'heading' => $block->get('subtitle'),
					'class' => 'pt-4 lg:pt-11',
				])
			@endif

		</div>
	</div>
</div>

<div class="container mx-auto bg-white md:-mt-24 lg:-mt-44 md:-mb-56 md:h-60 hidden md:block p-9 px-9 relative z-2">
</div>
