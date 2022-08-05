<div class="container mx-auto w-full lg:{{ $block->get('width') }} lg:h-[{{ $block->get('image')->get('height_desktop') }}]">

    <div class="flex lg:absolute z-10 w-full lg:{{ $block->get('image_width') }} h-[400px] lg:h-[{{ $block->get('image')->get('height_desktop') }}] bg-no-repeat bg-center @if($block->get('image')->get('position') === 'left') order-2 @endif"
        style="background-image: url('{{ wp_get_attachment_image_url($block->get('image')->get('image'), 'textblock-image') }}')">
    </div>

    <div class="flex justify-end pt-4 lg:pt-32 @if($block->get('image')->get('position') === 'left') order-1 @endif ">
        <div class="relative z-50 h-full w-full lg:{{ $block->get('text_width') }} lg:px-16 lg:py-20 bg-white ">
            @if($block->get('show_separate_title'))
                @include('components.headings.normal', [
                    'type' => 2,
                    'title' => $block->get('title'),
                    'class' => 'pb-4 lg:pb-8'
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
</div>