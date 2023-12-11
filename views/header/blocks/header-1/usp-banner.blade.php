@php
    $min_amount = get_free_shipping_minimum('BeNeDuLux');
    $uspsGroup = $block->get('usps');


    $uspsList = [];
    if($uspsGroup->get('use_global_usps') === true && !empty(get_fields('option')['usps'])) {
        $uspsList = (new \Illuminate\Support\Collection(get_fields('option')['usps']['usp_items']))->recursive();
    } else {
        $uspsList = $uspsGroup->get('usps');

    }
@endphp

<div class="bg-tertiary w-full rounded-t-lg">

    <!-- Desktop USP banner -->
    <div class="hidden lg:block usp_banner container mx-auto">
        <ul class="flex text-xs gap-6">
            @foreach ($uspsList as $usp)
                 <li class="usp-item">
                     <i class="text-secondary fas fa-check-circle"></i>
                     {!! str_replace('{free_shipping_minimum}', $min_amount, $usp->get('usp')) !!}
                </li>
            @endforeach
        </ul>
    </div>

    <!-- Mobile USP banner -->
    <div class="lg:hidden swiper uspSwiper text-center text-xs py-1">
        <ul class="swiper-wrapper">
            @foreach ($uspsList as $usp)
                <li class="swiper-slide sm:mr-6">
                    <i class="text-secondary fas fa-check-circle"></i>
                    {!! str_replace('{free_shipping_minimum}', $min_amount, $usp->get('usp')) !!}
                </li>
            @endforeach
        </ul>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", (event) => {
            new Swiper(".uspSwiper", {
                slidesPerView: 1,
                loop: true,
                autoplay: {
                    delay: 4000
                },
            });
        });
    </script>

</div>



