<div class="text-base pt-3 @if($product->get_type() !== 'simple') pb-8 @endif" >
    <span class="font-bold">Artikelnummer: </span> {{ $product->get_sku() }}
</div>

@if($product->get_type() === 'simple')
    <div class="text-base pt-2 ">
        <span class="font-bold">Afmetingen: </span> {{ $product->get_length() }} x {{  $product->get_width() }} x {{ $product->get_height() }} mm
    </div>
@endif

@if($product->get_attribute('eenheid'))
    <div class="text-base pt-2 pb-8">
        <span class="font-bold">Afname: </span> @if($product->get_attribute('aantal-eenheid'))
            {{ $product->get_attribute('aantal-eenheid') }} per{{ $product->get_attribute('eenheid') }}
        @else
            Per {{ $product->get_attribute('eenheid') }}

        @endif
    </div>
@endif
