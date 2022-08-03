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
					$img_size = 'gallery-thumbnail-1/1';
					break;
                case 'two-inline':
					$max = 2;
					$img_size = 'gallery-thumbnail-1/2';
                    break;
                case 'three-inline':
					$max = 3;
					$img_size = 'gallery-thumbnail-1/3';
                    break;
                default:
					// think of different display options.
            }

            $card_classes = 'm-2';
        @endphp

        @if($count > $max)
            @include('components.slider.slider', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
                'card_classes' => $card_classes,
            ])
        @else
            @include('components.slider.grid', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
				'img_size' => $img_size,
                'grid_class' => 'lg:grid-cols-'. $max .' '. $card_classes,
            ])
        @endif

    @endif

    <div class="flex justify-{{ $block->get('button')->get('position') }}">
        @include('components.buttons.default', [
            'button' => $block->get('button'),
            'colors' => 'btn-transparent text-primary-light disable-chevron',
        ])
    </div>

</div>