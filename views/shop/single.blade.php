@extends('layouts.main')

@section('content')



    <div class="container mx-auto">
        @include('components.breadcrumbs.index', [
            'breadcrumbsLocation' => 'outside',
            'headerName' => '',
            'breadcrumbsBackgroundColor' => 'bg-transparent',
            'breadcrumbsTextColor' => 'text-black'
        ])
        @php do_action('woocommerce_before_main_content') @endphp

        <div class="woocommerce-product-container">
            @while(have_posts())
                @php
                    the_post();
                    global $product;
                    $product = function_exists('wc_get_product') ? wc_get_product(get_the_ID()) : null;
                    if (function_exists('do_action')) do_action('woocommerce_before_single_product');
                @endphp

                <div id="product-{{ get_the_ID() }}" @php if (function_exists('wc_product_class')) wc_product_class('grid lg:mt-4 lg:grid-cols-10 lg:gap-16') @endphp>
                <div class="before-summary order-1 lg:order-1 lg:col-span-5">
                    @php 
                        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
                        do_action('woocommerce_before_single_product_summary'); 
                    @endphp
                </div>

                <div class="summary entry-summary order-2 lg:order-2 lg:col-span-5">
                    @php 
                        do_action('woocommerce_show_product_sale_flash');
                        do_action('woocommerce_single_product_summary'); 
                    @endphp
                </div>

                <div class="order-3 lg:col-span-10 product-tabs mt-8">
                    @php do_action('woocommerce_after_single_product_summary') @endphp
                </div>
            </div>
            @php do_action('woocommerce_after_single_product') @endphp
            @endwhile

            @php do_action('woocommerce_after_main_content') @endphp
        </div>

        <div class="page-builder">
            {!! the_content() !!}
        </div>
    </div>
@endsection
