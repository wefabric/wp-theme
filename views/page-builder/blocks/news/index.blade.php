@php
	switch ($block->get('show_type')) {
		case 'all':
		case 'type':
			$args = [
				'posts_per_page' => 9, // LIMIT argument for query. Won't return more than this amount.
				'post_type' => 'post',
			];
		
			if($block->get('show_type') == 'type') {
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

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
    @include('components.headings.normal', [
	    'type' => '2',
	    'class' => '',
	    'title' => $block->get('title'),
    ])

    @if(false)
        @include('components.slider.smart-slider', [
            'items' => $postList,
            'card_type' => 'newsitem',
        ])
    @else
        @include('components.slider.grid', [
            'items' => $postList,
            'card_type' => 'newsitem',
        ])
    @endif
	
	@if($block->get('buttons')->get('show_button'))
		<div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
			@foreach($block->get('buttons')->get('buttons') as $button)
				@include('components.buttons.default', [
					'button' => $button,
					'class' => 'disable-chevron font-bold',
					'a_class' => 'px-4',
				])
			@endforeach
		</div>
	@endif
	
</div>
