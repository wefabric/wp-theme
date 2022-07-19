<div class="">
    @if(!empty($title))
        <div class="font-bold text-2xl py-2">
            {{ $title }}
        </div>
    @endif

    @if(!empty($subtitle))
        <div class="font-bold text-xl py-4">
            {{ $subtitle }}
        </div>
    @endif

    @include('components.slider.smart-slider', [
        'items' => $usps,
        'card_type' => 'usp-large',
    ])

</div>
