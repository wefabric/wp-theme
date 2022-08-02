<div class="container mx-auto w-full lg:{{ $block->get('width') }} ">
    @if(!empty($block->get('title')))
        @include('components.headings.normal', [
	        'type' => 2,
	        'heading' => $block->get('title'),
        ])
    @endif

    @if(!empty($block->get('subtitle')))
        @include('components.headings.normal', [
            'type' => 3,
            'heading' => $block->get('subtitle'),
        ])
    @endif

    @if(!empty($block->get('photos')))
        @php
            $count = count($block->get('photos'));

            switch($block->get('display_type')) {
				case 'one-center':
					$max = 1;
					break;
                case 'two-inline':
					$max = 2;
                    break;
                case 'three-inline':
					$max = 3;
                    break;
            }
        @endphp

        @if($count > $max)
            @include('components.slider.slider', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
                'card_classes' => '', //'w-full lg:w-1/'. $max .' ',
            ])
        @else
            @include('components.slider.grid', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
                'grid_class' => 'lg:grid-cols-'. $max .' ',
            ])
        @endif

    @endif

</div>