@php
    $title = $block->get('title');
	$buttons = $block->get('buttons');
	$columns = $block->get('col_amount');
@endphp

<section class="cta relative px-4">

  <div class="container mx-auto px-4 lg:pt-40 lg:pb-40 md:pt-40 md:pb-30 sm:pt-20 sm:pb-20 relative lg:px-40 md:px-36 sm:px-4">

    <div class="grid lg:grid-cols-3 gap-1 md:grid-cols-1 sm:grid-cols-1 content-center">

    <div class="grid-item items-center">
      <div class="flex justify-center">
        <div class="icon bg-white justify-center text-center">
          <i class="fa-solid fa-check"></i>
        </div>
        <div class="ml-5 pr-5 cta-title text-white flex items-center">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        </div>
      </div>
    </div>

    <div class="grid-item items-center">
      <div class="flex justify-center">
        <div class="icon bg-tertiary justify-center content-center text-center text-white">
          <i class="fa-solid fa-check"></i>
        </div>
        <div class="ml-5 pr-5 cta-title text-white flex items-center">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        </div>
      </div>
    </div>

    <div class="grid-item items-center">
      <div class="flex justify-center">
        <div class="icon bg-primary justify-center content-center text-center text-white">
          <i class="fa-solid fa-check"></i>
        </div>
        <div class="ml-5 pr-5 cta-title text-white flex items-center">
          Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
        </div>
      </div>
    </div>

  </div>

  </div>

</section>


{{--

<div class="">

	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
		])
	@endif

    @include('components.slider.smart-slider', [
        'items' => $block->get('usps'),
        'card_type' => 'usp',

		'slider_on_items' => $columns,
		'breakPoints' => [
			768 => [ // md:
				'slidesPerView' => $columns,
			],
		],

		'grid_class' => 'flex justify-center',

        'size' => $block->get('icon_size'),
        'position' => $block->get('position'),
        'icon_color' => $block->get('icon_color'),
        'align' => $block->get('align')
    ])

	@if($buttons->get('show_button'))
		<div class="flex pt-6 lg:pt-10 justify-{{ $buttons->get('justify') }}">
			@foreach($buttons->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4 no-underline',
				])
			@endforeach
		</div>
	@endif

</div>

--}}
