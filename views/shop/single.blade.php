@extends('layouts.main')

@section('content')

	@include('components.breadcrumbs.index')

	<div class="container mx-auto px-8">
		@php(do_action('woocommerce_before_main_content'))
		
		<div class="woocommerce-product-container">
			@loop


			@php(do_action('woocommerce_before_single_product'))
			<div id="product-{{ Loop::id() }}" {{ wc_product_class('lg:mt-24 lg:grid-cols-9 lg:gap-32') }}>
				<div class="before-summary order-2 lg:order-1 lg:col-span-5">
					@php(do_action('woocommerce_before_single_product_summary'))
				</div>
	
				<div class="summary entry-summary order-1 lg:order-2 lg:col-span-4">
					@php(do_action('woocommerce_single_product_summary'))
				</div>
				
				<div class="order-3 lg:col-span-9">
					@php(do_action('woocommerce_after_single_product_summary'))
				</div>
			</div>
			@php(do_action('woocommerce_after_single_product'))
			@endloop
			
			@php(do_action('woocommerce_after_main_content'))
		</div>
		
		<div class="page-builder">
			{!! pageBuilder()->render(get_the_ID()) !!}
		</div>
	</div>
@endsection()
