@extends('layouts.main')

@section('content')
    <div class="header">
        {!! themeHeader()->render($page->ID) !!}
    </div>

	@if(!is_front_page())
		@include('components.breadcrumbs.index', ['classes' => ''])
	@endif

	<div class="container mx-auto">
		<h2 class="mx-auto text-center uppercase text-primary-dark my-9">
			Keep in touch
		</h2>
	</div>

	<section class="news-archive-grid relative pb-12">
		<div class="container mx-auto my-9">
			<div class="md:grid md:grid-cols-2 lg:grid-cols-3 gap-8 px-8">
				@loop
					@include('components.cards.newsitem', [
						'item' => get_the_ID()
					])
				@endloop
			</div>
		
			<div class="pagination text-center mt-12">
				@php
					the_posts_pagination( [
						'mid_size'  => 2,
						'prev_text' => __( '<', 'textdomain' ),
						'next_text' => __( '>', 'textdomain' ),
					]);
				@endphp
			</div>
		</div>
	
		<div class="bg-primary-dark absolute w-full h-96 bottom-0 left-0 -z-50">
			//bottom colored bar.
		</div>
	</section>
	
    <div class="page-builder">
        {!! pageBuilder()->render($page->ID) !!}
    </div>
@endsection
