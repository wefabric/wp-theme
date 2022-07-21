<div class="container mx-auto {{ $class ?? '' }}">
    @if(!empty($title))
        @include('components.headings.normal', [
            'type' => '2',
            'class' => 'font-bold text-2xl py-2',
            'heading' => $title,
        ])
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
