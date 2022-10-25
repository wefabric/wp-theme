@extends('layouts.main')

@section('content')
	<div class="container mx-auto">
		@php do_action('woocommerce_before_main_content') @endphp

		<header class="woocommerce-products-header">
			@if(apply_filters('woocommerce_show_page_title', true))
				<h1 class="woocommerce-products-header__title page-title">{{ woocommerce_page_title(false) }}</h1>
			@endif
			@php do_action('woocommerce_archive_description') @endphp
		</header>

		<div class="flex flex-row w-full gap-4 lg:gap-32">
			@if(function_exists('dynamic_sidebar'))
				<div class="sidebar">
					@include('components.woocommerce.category-tree')
					
					@php dynamic_sidebar('sidebar-shop') @endphp
				</div>
			@endif
			
			<div class="w-full lg:w-3/4">
				@if(woocommerce_product_loop())
					@php do_action('woocommerce_before_shop_loop') @endphp
					
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
