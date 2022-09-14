<div class="@if($block->get('width') !== 'nomargin') container @endif mx-auto w-full lg:{{ $block->get('width') === 'nomargin' ? 'w-full' : $block->get('width') }} ">
	
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.normal', [
            'type' => 2,
            'title' => $block->get('title'),
        ])
    @endif

    @if(!empty($block->get('videos')))
        @php
            $count = count($block->get('videos'));

            switch($block->get('display_type')) {
                case 'one':
                    $columns = 1;
                    $img_size = 'gallery-thumbnail-1/1';
                    if($block->get('width') === 'nomargin') {
                        $img_size .= '-nomargin';
                    }
                    break;
                case 'two':
                    $columns = 2;
                    $img_size = 'gallery-thumbnail-1/2';
                    break;
                case 'three':
                    $columns = 3;
                    $img_size = 'gallery-thumbnail-1/3';
                    break;
                default:
                    // think of different display options.
            }

            if($block->get('width') !== 'nomargin') {
                $card_classes = 'm-0';
            }
        @endphp

        @include('components.slider.grid', [
            'items' => $block->get('videos'),
            'card_type' => 'video',
            'img_size' => $img_size,
            'grid_class' => 'gap-4 lg:grid-cols-'. $columns .' '. ($card_classes ?? ''),
        ])
    @endif

    @if($block->get('show_button'))
        <div class="flex justify-{{ $block->get('button')->get('position') }}">
            @include('components.buttons.default', [
                'button' => $block->get('button'),
                'colors' => 'btn-transparent text-primary-light disable-chevron',
            ])
        </div>
    @endif

</div>
