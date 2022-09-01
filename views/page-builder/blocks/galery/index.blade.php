<div class="@if($block->get('width') !== 'nomargin') container @endif mx-auto w-full lg:{{ $block->get('width') === 'nomargin' ? 'w-full' : $block->get('width') }} ">

    @if($block->get('show_separate_title'))
        @include('components.headings.normal', [
            'type' => 2,
            'title' => $block->get('title'),
        ])
    @endif

    @if(!empty($block->get('photos')))
        @php
            $card_classes = '';
            $count = count($block->get('photos'));

            switch($block->get('display_type')) {
				case 'one-center':
					$max = 1;
					$img_size = 'gallery-thumbnail-1/1';
					if($block->get('width') === 'nomargin') {
    					$img_size .= '-nomargin';
					}
					break;
                case 'two-inline':
					$max = 2;
					$img_size = 'gallery-thumbnail-1/2';
                    break;
                case 'three-inline':
					$max = 3;
					$img_size = 'gallery-thumbnail-1/3';
                    break;
                case 'logo-slider':
					$max = 0; //force slider
					$img_size = 'header_logo';
					$image_class = 'bg-contain bg-center';
					$breakPoints = [
					    1024 => [
                            'slidesPerView' => min($count, 5), // 'auto'
                            'spaceBetween' => 30,
                            'centeredSlides' => true,
                            'autoplay' => [
                              'delay' => 2500,
                              'disableOnInteraction' => false,
                            ],
                        ],
                    ];
                    break;
                default:
					// think of different display options.
            }

			if($block->get('width') !== 'nomargin') {
                $card_classes .= ' m-0';
			}
        @endphp

{{--
    TODO create a switch to force slider when more images uploaded than columns specified.
    If ! slider, then show specified columns and multiple rows of images.
    2 columns, 4 photos --> 2x2 grid. Slider switch enabled? Slider of two images side-by-side.
--}}

        @if($count > $max)
            @include('components.slider.slider', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
                'img_size' => $img_size ?? 'full',
                'prevNext' => false,
                'breakPoints' => $breakPoints ?? [],
                'card_classes' => ($card_classes ?? ''),
                'image_class' => $image_class ?? '',
            ])
        @else
            @include('components.slider.grid', [
                'items' => $block->get('photos'),
                'card_type' => 'image',
				'img_size' => $img_size,
                'grid_class' => 'gap-4 lg:grid-cols-'. $max .' '. ($card_classes ?? ''),
            ])
        @endif

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