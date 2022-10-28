@php

    $downloads = (new \Illuminate\Support\Collection())->merge($block->get('downloads'))->merge($block->get('downloads'))->merge($block->get('downloads'))->merge($block->get('downloads'));

@endphp
<div class="container max-w-4/5 px-4 md:px-8 lg:px-0 mx-auto py-8 lg:py-16 ">
    @if($block->get('title'))
        <h2 class=" inline-block w-full align-text-top z-10 pb-6 lg:pb-12 @if($downloads->count() > 3) lg:pl-28  @endif text-left ">{{ $block->get('title') }}</h2>
    @endif

    <div class="md:flex md:flex-row pb-4 lg:pb-8 gap-8 " >
        <div class="lg:w-1/3">
            <div class="flex @if($downloads->count() > 3) lg:pl-28  @endif ">
                @include('components.image', [
                   'image_id' => $block->get('image'),
                   'size' => 'brand_logo',
                   'class' => ' mx-auto md:mx-0 mb-4 md:mb-0 bg-white p-4 disable-rounded rounded-lg h-[200px] w-[200px] border border-color-[#D2D2D2]',
                   'img_class' => 'bg-center bg-no-repeat mx-auto relative top-[45%]',
               ])
            </div>
        </div>

        @if($block->get('excerpt'))
            <div class="lg:w-2/4">
                @include('components.content', [
                    'content' => $block->get('excerpt'),
                ])
            </div>
        @endif
    </div>

    @include('components.slider.smart-slider', [
          'items' => $downloads,
          'arrows' => true,
          'dots' => true,
          'card_type' => 'download',
      ])
</div>


