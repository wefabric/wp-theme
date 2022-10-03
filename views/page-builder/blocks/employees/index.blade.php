@php
    if($block->get('show_all') === true) {
        $args = [
            'posts_per_page'   => 8,
            'post_type'        => 'employees',
        ];
        $query = new WP_Query( $args );
        $postList = $query->posts;
    } else {
	    $postList = $block->get('employees'); //preselected list
    }
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
	
	@if($block->get('title')->get('show_separate_title'))
		@include('components.headings.collection', [
			'title' => $block->get('title'),
			'disable_buttom_padding' => true,
		])
	@endif
	
	@if($block->get('display_type') === 'slider')
		@include('components.slider.smart-slider', [
			'items' => $postList,
			'card_type' => 'employee',
		])
	@elseif($block->get('display_type') === 'grid')
		@include('components.slider.grid', [
			'items' => $postList,
			'card_type' => 'employee',
		])
	@endif
</div>
