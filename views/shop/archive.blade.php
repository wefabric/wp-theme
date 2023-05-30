@extends('layouts.main')

@section('content')
	<div class="container mx-auto">
		@php do_action('woocommerce_before_main_content') @endphp

		<header class="woocommerce-products-header">
			@if(apply_filters('woocommerce_show_page_title', true))
				<h1 class="woocommerce-products-header__title page-title">{{ woocommerce_page_title(false) }}</h1>
			@endif
            <div class="mx-auto lg:max-w-4xl px-4 lg:px-0">
					@php do_action('woocommerce_archive_description') @endphp
			</div>

		</header>

		<div class="lg:flex lg:flex-row w-full gap-4 lg:gap-32">
			@if(function_exists('dynamic_sidebar'))
				<div class="sidebar mb-4 lg:mb-8 ">

					<div class="hidden lg:block">
						@include('components.woocommerce.category-tree')
					</div>


					<div class="lg:hidden flex flex-row items-center gap-4 px-4 lg:px-0">
						<div class="">
							<span class="btn btn-black show-filters hover:bg-black "><i class="fa-solid fa-sliders"></i> Filters</span>
						</div>
						<div>
							<a class="hover:underline" href="#products-start">Ga naar producten <i class="fa-solid fa-circle-chevron-right pl-1"></i></a>
						</div>
					</div>



					<div class="shop-filters mt-4 lg:mt-0 hidden lg:block w-full">
						<div class="px-4 lg:px-0">
							@php dynamic_sidebar('sidebar-shop') @endphp
						</div>

						<div class="sticky bottom-0 p-4 text-center z-10 w-full bg-white border border-white shadow-md lg:hidden">
							<a href="#products-start" class="btn btn-primary sticky show-products">Toon producten</a>
						</div>

					</div>

					<script>
						jQuery( document ).ready(function($) {
							$('.show-filters').click(function (){
								$('.shop-filters').toggleClass('hidden');
							});
							$('.show-products').click(function (){
								$('.shop-filters').addClass('hidden');
							});

						});
					</script>

				</div>
			@endif
			
			<div class="px-4 m md:px-8 lg:px-0 w-full lg:w-3/4 shop_content">
				@if(woocommerce_product_loop())
					@unless(is_search())
						@php do_action('woocommerce_before_shop_loop') @endphp
					@endunless
					
					{!! woocommerce_product_loop_start(false) !!}
					
					@if(wc_get_loop_prop('total'))
						@while(have_posts())
							@php the_post() @endphp
							
							@php do_action('woocommerce_shop_loop') @endphp
							@php wc_get_template_part('content', 'product') @endphp
						@endwhile
					@endif
					
					{!! woocommerce_product_loop_end(false) !!}
					
					@php do_action('woocommerce_after_shop_loop') @endphp
				@else
					@php do_action('woocommerce_no_products_found') @endphp
				@endif
				
				@php do_action('woocommerce_after_main_content') @endphp
			</div>
		</div>
		
		<div class="page-builder">
			@php
				$obj = get_queried_object(); //category
				if($obj instanceof WP_Post_Type && $obj->name === 'product') {
					$obj = get_option('woocommerce_shop_page_id');
				} //if shop, get the page ID instead
			@endphp
			{!! pageBuilder()->render($obj) !!}
		</div>
	</div>
@endsection
