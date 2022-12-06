<div class="flex justify-end ">
    <div class="text-center">
        <div class="relative text-center w-full text-sm py-4">
            <span class="absolute top-[5px] left-0 w-full px-1 mx-auto inline-block z-2">of</span>
        </div>
        <h4 class="pb-4">Zakelijk bestellen</h4>
        @include('components.buttons.default', [
            'href' => \App\Helpers\Offer::getUrl($product), //todo optie van maken?
            'text' => 'Offerte opvragen',
            'a_class' => '',
            'colors' => 'btn-black text-white',
        ])
    </div>

</div>