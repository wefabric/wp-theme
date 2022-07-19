<div class="mx-auto w-full lg:flex lg:{{ $block->get('width') }}">

    <div class="w-full lg:w-4/6 @if($block->get('image_position') === 'left') order-1 lg:order-2 lg:pl-16 @else lg:pr-16 @endif @switch($block->get('image_vertical_position')) {{-- For aligning the text,when shorter than the image. --}}
            @case('middle') lg:my-auto @break
            @case('bottom') lg:mt-auto lg:mb-0 @break;
        @endswitch ">
        @include('components.content', [
            'content' => apply_filters('the_content', $block->get('text')),
            'class' => 'text-justify'
        ])
    </div>

    <div class="w-full lg:w-2/6 pt-8 lg:pt-0 @if($block->get('image_position') === 'left') order-2 lg:order-1 @endif @switch($block->get('image_vertical_position'))
            @case('middle') lg:my-auto @break
            @case('bottom') lg:mt-auto lg:mb-0 @break;
        @endswitch ">
        @if($block->get('image'))
            @include('components.image', [
                'image_id' => $block->get('image'),
                'class' => 'mx-auto'
            ])
        @endif
    </div>
</div>