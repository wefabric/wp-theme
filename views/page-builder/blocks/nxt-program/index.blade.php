@php
    if($block->get('title')->get('show_separate_title')) {
        $title = $block->get('title');
        switch($title->get('title_position')) { //based on the textblock
            case 'above':
                $div_class = 'flex-col';
                $title_class = 'order-1';
                $text_class = 'order-2';
                break;
            case 'left':
                $div_class = 'flex-row';
                $title_class = 'lg:w-1/2 order-1';
                $text_class = 'lg:w-1/2 order-2';
                break;
            case 'right':
                $div_class = 'flex-row';
                $title_class = 'lg:w-1/2 order-2';
                $text_class = 'lg:w-1/2 order-1';
                break;
            case 'below':
                $div_class = 'flex-col';
                $title_class = 'order-2';
                $text_class = 'order-1';
                break;
        }
    } else {
        $div_class = '';
        $title_class = '';
        $text_class = '';
    }
@endphp

<div class="program lg:block px-4">
  <div class="container mx-auto lg:px-0 md:px-0 sm:px-0">
    <div class="grid gap-2 lg:grid-cols-2 md:grid-cols-1 sm:grid-cols-1">
      <div class="info lg:py-40 lg:pr-6 sm:pr-0 mb-5">
        @if($block->get('title')->get('show_separate_title'))
          @include('components.headings.collection', [
            'title' => $block->get('title'),
          ])
        @endif
        <div class="w-10/12 md:w-10/12 sm:w-full text-white">
          @include('components.content', [
              'content' => $block->get('text'),
              'class' => 'text-'. $block->get('text_align'),
          ])
        </div>
        @if($block->get('buttons')->get('show_button'))
          <div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
            @foreach($block->get('buttons')->get('buttons') as $button)
              @include('components.buttons.default', [
                'button' => $button,
                'a_class' => 'px-4',
              ])
            @endforeach
          </div>
        @endif
      </div>
      <div class="agenda bg-tertiary lg:py-20 md:py-16 sm:py-16 lg:pl-20 md:pl-20 sm:pl-20 z-10">

        <div class="inner bg-white lg:p-20 md:p-10 sm:p-5 z-10">

          <div class="flex flex-row w-full mb-5">
            <div class="w-3/12">
              <div class="flex-none icon">
                <i class="fa-regular fa-calendar"></i>
              </div>
            </div>
            <div class="w-9/12 ml-1 flex item-center">
              <div class="mt-3">
                <h6>Datum</h6>
                <span>@php the_field('date','option'); @endphp</span>
              </div>
            </div>
          </div>

          <div class="flex flex-row w-full mb-5">
            <div class="w-3/12">
              <div class="flex-none icon">
                <i class="fa-regular fa-clock"></i>
              </div>
            </div>
            <div class="w-9/12 ml-1 flex item-center">
              <div class="mt-3">
                <h6>Tijd</h6>
                <span>@php the_field('time','option'); @endphp</span>
              </div>
            </div>
          </div>

          <div class="flex flex-row w-full mb-5">
            <div class="w-3/12">
              <div class="flex-none icon">
                <i class="fa-solid fa-euro-sign"></i>
              </div>
            </div>
            <div class="w-9/12 ml-1 flex item-center">
              <div class="mt-3">
                <h6>Kosten</h6>
                <span>@php the_field('cost','option'); @endphp</span>
              </div>
            </div>
          </div>

          <div class="flex flex-row w-full">
            <div class="w-3/12">
              <div class="flex-none icon">
                <i class="fa-solid fa-map-location-dot"></i>
              </div>
            </div>
            <div class="w-9/12 ml-1 flex item-center">
              <div class="mt-3">
                <h6>Locatie</h6>
                <span>@php the_field('location','option'); @endphp</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
