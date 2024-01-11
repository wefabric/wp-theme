@extends('layouts.main')

@section('content')

	<div class="page-builder">
		{!! apply_filters('the_content', get_post_field('post_content', $page->ID)) !!}
	</div>

    <div class="header">
        {!! themeHeader()->render($page->ID) !!}
    </div>

{{--	@include('components.breadcrumbs.index', ['classes' => ''])--}}

	<div class="container px-8 pt-6 lg:pt-12 mx-auto">
		@include('components.news.category-list')
	</div>

	<section class="news-archive-grid relative">
		<div class="container mx-auto my-12 lg:my-12">
			<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-y-16 gap-x-4 lg:gap-x-8 px-8">
				@loop
					@include('components.cards.newsitem', [
						'item' => get_the_ID()
					])
				@endloop
			</div>

			<div class="pagination text-center mt-12 lg:mt-24">
				@php
					the_posts_pagination( [
						'mid_size'  => 1,
						'prev_next' => false,
//						'prev_text' => __( '<', 'textdomain' ),
//						'next_text' => __( '>', 'textdomain' ),
					]);
				@endphp
			</div>
		</div>
	</section>

@endsection