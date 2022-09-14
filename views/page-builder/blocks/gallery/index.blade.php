<div class="@if($block->get('width') !== 'nomargin') container @endif mx-auto w-full lg:{{ $block->get('width') === 'nomargin' ? 'w-full' : $block->get('width') }} ">

    @if($block->get('title')->get('show_separate_title'))
        @include('components.headings.normal', [
            'type' => 2,
            'title' => $block->get('title'),
        ])
    @endif

    @if(!empty($block->get('photos')))
        @php
            $card_classes = '';

            $count = count($block->get('photos'));
			$columns = $block->get('display_columns');

			switch($block->get('display_type')) {
				case 'grid':
					$img_size = 'gallery-thumbnail-1/'. $columns;
					if($columns == 1 && $block->get('width') === 'nomargin') {
    					$img_size .= '-nomargin';
					}
					break;
					
				case 'logo-slider':
					$img_size = 'header_logo';
					// no break;
				case 'slider':
					if(!isset($img_size)) {
						$img_size = 'full'; //TODO test
					}
					$image_class = 'bg-contain bg-center';
					$breakPoints = [
						1 => [ //mobile
						    'slidesPerView' => 1,
                            'spaceBetween' => 30,
                            'centeredSlides' => true,
                            'autoplay' => [
                              'delay' => 2500,
                              'disableOnInteraction' => false,
                            ],
						],
						640 => [ //small tablet
						    'slidesPerView' => min($count, $columns, 2),
                            'spaceBetween' => 30,
                            'centeredSlides' => true,
                            'autoplay' => [
                              'delay' => 2500,
                              'disableOnInteraction' => false,
                            ],
						],
						768 => [ //larger tablet, or small laptop
						    'slidesPerView' => min($count, $columns, 3),
                            'spaceBetween' => 30,
                            'centeredSlides' => true,
                            'autoplay' => [
                              'delay' => 2500,
                              'disableOnInteraction' => false,
                            ],
						],
					    1024 => [ //most self-respecting laptops
                            'slidesPerView' => min($count, $columns, 5), // 'auto'
                            'spaceBetween' => 30,
                            'centeredSlides' => true,
                            'autoplay' => [
                              'delay' => 2500,
                              'disableOnInteraction' => false,
                            ],
                        ],
                    ];
					break;
			}

			if($block->get('width') !== 'nomargin') {
                $card_classes .= ' m-0';
			}
        @endphp

        @if($block->get('display_type') !== 'grid')
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
                'grid_class' => 'gap-4 lg:grid-cols-'. $columns .' '. ($card_classes ?? ''),
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