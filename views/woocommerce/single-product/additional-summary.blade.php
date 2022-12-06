<div class="pb-8 flex flex-col pt-3 gap-1">
    <div class="text-base " >
        <span class="font-bold">Artikelnummer: </span> {{ $product->get_sku() }}
    </div>

    @if($product->get_type() === 'simple')
        <div class="text-base">
            <span class="font-bold">Afmetingen: </span> {{ $product->get_length() }} x {{  $product->get_width() }} x {{ $product->get_height() }} mm
        </div>
    @endif

    @if($product->get_attribute('eenheid'))
        <div class="text-base">
            <span class="font-bold">Afname: </span>
            {{ \App\Helpers\Product::getQuantityUnit($product) }}
        </div>
    @endif
</div>

