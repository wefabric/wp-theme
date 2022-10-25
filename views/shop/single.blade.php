@extends('layouts.main')

@section('content')
	<div class="container mx-auto">
		@php(do_action('woocommerce_before_main_content'))
		
		<div class="">
			@loop
			@php(do_action('woocommerce_before_single_product'))
			<div id="product-{{ Loop::id() }}" {{ wc_product_class('lg:mt-24') }}>
				@php(do_action('woocommerce_before_single_product_summary'))
				
				<div class="summary entry-summary">
					@php(do_action('woocommerce_single_product_summary'))
				</div>
				
				@php(do_action('woocommerce_after_single_product_summary'))
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