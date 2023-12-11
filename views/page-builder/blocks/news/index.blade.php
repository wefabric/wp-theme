@php

	$limit = 9;
	switch ($block->get('show_type')) {
		case 'all-3':
		case 'type-3':
			$limit = 3;
			
		case 'all':
		case 'type':
			$args = [
				'posts_per_page' => $limit, // LIMIT argument for query. Won't return more than this amount.
				'post_type' => 'post',
			];
		
			if($block->get('show_type') == 'type' || $block->get('show_type') == 'type-3') {
				$args['tax_query'] = [
					'relation' => 'OR'
				];
				foreach($block->get('news_type') as $tax) {
					$args['tax_query'][] = [
						'taxonomy' => $tax['taxonomy'],
						'field' => 'slug', // ??
						'terms' => [
							$tax['slug']
						 ]
					];
				}
			}
		
			$query = new WP_Query( $args );
			$postList = $query->posts;
			break;
		case 'select':
			$postList = $block->get('news'); //preselected list
			break;
	}
@endphp

<div class="">
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
		])
	@endif
	
    @if(false)
        @include('components.slider.smart-slider', [
            'items' => $postList,
            'card_type' => 'newsitem',
            'mobile_loop_max' => 1,
        ])
    @else
        @include('components.slider.grid', [
            'items' => $postList,
            'card_type' => 'newsitem',
            'mobile_loop_max' => 1,
            'grid_spacing' => 'md:gap-8',
        ])
    @endif
	
	@if($block->get('buttons')->get('show_button'))
		<div class="flex pt-6 lg:pt-10 justify-{{ $block->get('buttons')->get('justify') }}">
			@foreach($block->get('buttons')->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'a_class' => 'px-4',
				])
			@endforeach
		</div>
	@endif
	
</div>
