@php
    if($block->get('show_separate_title')) {
        $title = $block->get('title');
        switch($title->get('title_position')) { //based on the textblock
            case 'above':
                $div_class = 'flex flex-col gap-y-2';
                $title_class = 'order-1';
                $text_class = 'order-2';
                break;
            case 'left':
                $div_class = 'flex flex-row gap-x-2';
                $title_class = 'w-1/2 order-1';
                $text_class = 'w-1/2 order-2';
                break;
            case 'right':
                $div_class = 'flex flex-row gap-x-2';
                $title_class = 'w-1/2 order-2';
                $text_class = 'w-1/2 order-1';
                break;
            case 'below':
                $div_class = 'flex flex-col gap-y-2';
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

<div class="container mx-auto w-full lg:{{ $block->get('width') }} {{ $div_class }} text-{{ $block->get('text_color') }}  flex">
    @if($block->get('show_separate_title'))
        <div class="{{ $title_class }} text-{{$title->get('title_align')}}">
            @include('components.headings.normal', [
	            'type' => 2,
				'title' => $title,
            ])
        </div>
    @endif

    <div class="{{ $text_class }} flex flex-col">
        <div class="py-4 lg:py-8">
            @include('components.content', ['content' => apply_filters('the_content', $block->get('text'))])
        </div>

        @if($block->get('button'))
            <div class="flex justify-{{ $block->get('button')->get('position') }}">
                @include('components.buttons.default', [
                    'button' => $block->get('button'),
                    'class' => 'disable-chevron font-bold'
                ])
            </div>
        @endif
    </div>
</div>
