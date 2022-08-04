<div class="container mx-auto w-full lg:flex lg:{{ $block->get('width') }}">

    <div class="relative z-10 w-full lg:{{ $block->get('image_width') }}  lg:h-[{{ $block->get('image')->get('height_desktop') }}] @if($block->get('image')->get('position') === 'left') order-1 lg:order-2 lg:pl-16 @else lg:pr-16 @endif"
        style="background-image: url('{{ wp_get_attachment_image_url($block->get('image')->get('image'), 'textblock-image') }}')">
    </div>

    <div class="relative z-50 h-full w-full lg:{{ $block->get('text_width') }} lg:my-auto lg:px-16 lg:py-20 @if($block->get('image')->get('position') === 'left') order-2 lg:order-1 @endif">
        @if($block->get('show_separate_title'))
            @include('components.headings.normal', [
	            'type' => 2,
	            'title' => $block->get('title'),
            ])
        @endif

        @include('components.content', [
            'content' => apply_filters('the_content', $block->get('text')),
            'class' => 'text-justify'
        ])

        @if($block->get('show_button'))
            <div class="flex justify-{{ $block->get('button')->get('position') }}">
                @include('components.buttons.default', [
                    'button' => $block->get('button'),
                    'class' => 'disable-chevron font-bold'
                ])
            </div>
        @endif
    </div>
</div>