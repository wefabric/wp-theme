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

<section class="banner relative px-4 lg:py-40 md:py-30 sm:py-20 @if(!empty($bg)) {{ $bg }} @endif" @if(!empty($gradient)) style="{{ $gradient }}" @endif>
  <div class="flex flex-row container mx-auto">
      <div class="lg:block lg:w-8/12 md:w-10/12 sm:w-full items-center z-20">
				@include('components.headings.collection', [
					'titles' => $block->get('title'),
					'title_color' => $block->get('text_color') ?? '',
					'disable_bottom_padding' => 'true'
				])

				@if(!empty($block->get('call_to_actions')))
					@foreach($block->get('call_to_actions') as $item)
							@php
									$cta = $item->get('cta');
							@endphp

							@if($cta->get('type') === 'button')
									@include('components.buttons.default', [
										'button' => $cta,
											'class' => 'btn btn-primary btn-large bg-orange hover:bg-white hover:text-black text-white mt-10'
									])
							@elseif($cta->get('type') === 'link')
									@include('components.buttons.default', [
										'button' => $cta,
											'class' => 'btn btn-primary btn-large bg-orange hover:bg-white hover:text-black text-white mt-10'
									])
							@endif
					@endforeach
				@endif

				{{--
					<h3 class="small-subtitle uppercase mb-10 text-white ">
						Donderdag 9 maart 2023
					</h3>
          <h1 class="text-white uppercase">
            Hét event voor MKB ondernemers in Friesland
          </h1>
          <a href="#" title="Direct inschrijven" class="btn btn-primary btn-large bg-orange hover:bg-white hover:text-black text-white mt-10">
            Direct inschrijven
          </a>
				--}}
      </div>
  </div>
  <div class="image z-10"></div>
</section>
