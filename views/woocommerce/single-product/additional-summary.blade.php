{{--<div class="pb-8 flex flex-col pt-3 gap-1 product_meta custom">--}}
{{--    <div class="lg:hidden">--}}
{{--        {!! wc_get_template( 'single-product/product-image.php' ); !!}--}}
{{--    </div>--}}

{{--    <span class="block text-base sku_wrapper" >--}}
{{--        <span class="font-bold ">Artikelnummer: </span> <span class="sku">{{ $product->get_sku() }}</span>--}}
{{--    </span>--}}

{{--    @if($product->get_type() === 'simple')--}}
{{--        <div class="text-base">--}}
{{--            @php--}}
{{--                $sizes = [$product->get_length().'L',  $product->get_width().'B', $product->get_height().'H']--}}
{{--            @endphp--}}
{{--            <span class="font-bold">Afmetingen: </span> {{ implode('x ', $sizes) }} mm--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    @if($product->get_attribute('eenheid'))--}}
{{--        <div class="text-base">--}}
{{--            <span class="font-bold">Afname: </span>--}}
{{--            {{ \App\Helpers\Product::getQuantityUnit($product) }}--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</div>--}}

