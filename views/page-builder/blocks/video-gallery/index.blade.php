<div class="">
	
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
		])
	@endif

    @if(!empty($block->get('videos')))
        @php
            $count = count($block->get('videos'));
			$columns = $block->get('display_columns');
			$img_size = 'gallery-thumbnail-1/'. $columns;

			if($columns == 1 && $block->get('sizes')->get('width') === 'nomargin') {
				$img_size .= '-nomargin';
			}

            if($block->get('sizes')->get('width') !== 'nomargin') {
                $card_classes = 'm-0';
            }
        @endphp

        @include('components.slider.grid', [
            'items' => $block->get('videos'),
            'card_type' => 'video',
            'img_size' => $img_size,
            'grid_class' => 'grid lg:grid-cols-'. $columns .' '. ($card_classes ?? ''),
            'grid_spacing' => 'gap-4',
        ])
    @endif
		
	@if($block->get('buttons')->get('show_button'))
		<div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
			@foreach($block->get('buttons')->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4',
				])
			@endforeach
		</div>
	@endif
	
</div>
