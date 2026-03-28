@extends('layouts.main')

@section('content')
	<div class="container mx-auto lg:px-8">
		@include('components.breadcrumbs.index')
		@php do_action('woocommerce_before_main_content') @endphp

		<div class="lg:flex lg:flex-row w-full gap-4 lg:gap-16">
			@if(function_exists('dynamic_sidebar'))
				<div class="sidebar mb-4 lg:mb-8 ">

					<div class="hidden lg:block">
						@include('components.woocommerce.category-tree')
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

        @php
            $postContent = get_post_field('post_content', $page->ID);
        @endphp

        <div class="page-builder px-4 lg:px-0">
            {!! apply_filters('the_content', $postContent) !!}
        </div>

	</div>
@endsection
