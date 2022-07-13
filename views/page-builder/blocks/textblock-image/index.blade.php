<div class="mx-auto w-full flex lg:{{ $block->get('width') }}">
    <div class="lg:w-4/6 @if($block->get('image_position') === 'left') order-1 lg:order-2 pl-8 lg:pl-16 @else pr-8 lg:pr-16 @endif @switch($block->get('image_vertical_position')) {{-- For aligning the text,when shorter than the image. --}}
            @case('middle') lg:my-auto @break
            @case('bottom') lg:mt-auto lg:mb-0 @break;
        @endswitch ">
        @include('components.content', [
            'content' => apply_filters('the_content', $block->get('text')),
            'class' => 'text-justify'
        ])
    </div>
    <div class="lg:w-2/6 @if($block->get('image_position') === 'left') order-2 lg:order-1 @endif @switch($block->get('image_vertical_position'))
            @case('middle') lg:my-auto @break
            @case('bottom') lg:mt-auto lg:mb-0 @break;
        @endswitch ">
        @if($block->get('image'))
            @include('components.image', [
                'image_id' => $block->get('image'),
                'alt' => '',
                'class' => 'w-full h-full object-cover'
            ])
        @endif
    </div>
</div>