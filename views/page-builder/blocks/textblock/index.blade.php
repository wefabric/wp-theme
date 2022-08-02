@php
    if($block->get('show_separate_title')) {
        switch($block->get('title_position')) { //based on the textblock
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

<div class="container mx-auto w-full lg:{{ $block->get('width') }} {{ $div_class }}">
    @if($block->get('show_separate_title'))
        <div class="{{ $title_class }}">
            @include('components.headings.normal', [
	            'type' => 2,
	            'heading' => $block->get('title'),
            ])
        </div>
    @endif

    <div class="{{ $text_class }}">
        @include('components.content', ['content' => apply_filters('the_content', $block->get('text'))])
    </div>
</div>
