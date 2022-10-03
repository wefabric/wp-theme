@php
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

<div class="header header-1 w-full @if(!empty($bg)) {{ $bg }} @endif" @if(!empty($gradient)) style="{{ $gradient }}" @endif>
    <div class="image py-15 lg:{{ $block->get('vertical_space') }} mx-4 lg:mx-20 bg-center bg-cover bg-no-repeat z-50 relative rounded-lg" style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}')">
		<div class="bg-black opacity-20 -z-1 absolute h-full w-full top-0 left-0 rounded-lg"></div> {{-- black shade over image. --}}
	
		@if(!empty($videoUrl))
			<div class="hidden lg:block"> {{-- only show on desktop, to prevent data usage when on mobile--}}
				<video class="header-video" width="100%" height="100%" autoplay loop muted>
					<source src="{{ $videoUrl }}" type="video/mp4" />
					Your browser does not support HTML video.
				</video>
			</div>
		@endif

        <div class="container mx-auto w-full lg:w-3/4 py-14 lg:py-0 flex flex-col items-center text-center text-{{ $block->get('text_color') }}">
	
			@include('components.headings.collection', [
				'titles' => $block->get('title'),
				'title_color' => $block->get('text_color')
			])
			
			@if(!empty($block->get('call_to_actions')))
                <div class="flex flex-col lg:flex-row justify-center pt-4 lg:pt-8">
                    @foreach($block->get('call_to_actions') as $item)
                        @php
                            $cta = $item->get('cta');
                        @endphp

                        @if($cta->get('type') === 'button')
                            @include('components.buttons.default', [
	                            'button' => $cta,
                                'class' => ''
                            ])
                        @elseif($cta->get('type') === 'link')
                            @include('components.buttons.default', [
	                            'button' => $cta,
                                'class' => 'btn-transparent'
                            ])
                        @endif
                    @endforeach
                </div>
            @endif
			
        </div>
    </div>
</div>
