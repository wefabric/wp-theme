@php
    if($block->get('show_all') === true) {
        $args = [
            'posts_per_page'   => 99,
            'post_type'        => 'employees',
        ];
        $query = new WP_Query( $args );
        $postList = $query->posts;
    } else {
	    $postList = $block->get('employees'); //preselected list
    }
@endphp


<section class="sponsoren px-4">

  <div class="relative">
    <div class="container mx-auto">
      <div class="inner relative z-10 lg:pt-40 lg:pb-40 md:pt-30 md:pb-40 sm:pt-20 sm:pb-40">
        <div class="text-white">
          <h2 class="mb-5 uppercase">Met trots de sponsoren</h2>
          <p>
            Wij zijn ontzettend trots dat we deze prachtige bedrijven mogen verbinden aan het NXT event. Ook je naam verbinden aan hét MKB-event van Friesland? Neem contact op voor de mogelijkheden.
          </p>
          <a href="#" title="Bekijk het volledige programma" class="btn btn-transparent text-white uppercase">
            Bekijk alle sponsoren
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="carousel lg:pb-40 md:pt-40 md:pb-40 sm:pb-20 relative z-50">
    <div class="container mx-auto">
      <div class="grid lg:grid-cols-3 gap-10 md:grid-cols-2 sm:grid-cols-2">
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/wefabric.png" class="" alt="" />
        </div>
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/miedema.png" class="" alt="" />
        </div>
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/broeksterkerk.png" class="" alt="" />
        </div>
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/miedema.png" class="" alt="" />
        </div>
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/broeksterkerk.png" class="" alt="" />
        </div>
        <div class="logo-wrapper flex items-center justify-center md:mb-4 p-10">
          <img src="{{ bloginfo('template_directory'); }}/assets/images/wefabric.png" class="" alt="" />
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
			'disable_buttom_padding' => true,
		])
	@endif

	@if($block->get('display_type') === 'slider')
		@include('components.slider.smart-slider', [
			'items' => $postList,
			'card_type' => 'employee',
		])
	@elseif($block->get('display_type') === 'grid')
		@include('components.slider.grid', [
			'items' => $postList,
			'card_type' => 'employee',
		])
	@endif
</div>

--}}
