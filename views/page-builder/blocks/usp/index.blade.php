<div class="container mx-auto">
    <div class="mb-6 text-center">
        @if($block->get('title'))
            <h2>{!! $block->get('title') !!}</h2>
        @endif
        @if($block->get('subtitle'))
            <h3>{!! $block->get('subtitle') !!}</h3>
        @endif
    </div>
    <div class="md:grid @if($block->get('col_amount')) md:grid-cols-{{ $block->get('col_amount') }} @else md:grid-cols-2 @endif slick-carousel usp-slider">
        @if($block->get('usps'))
            @include('components.usps.list', ['usps' => $block->get('usps')])
        @endif
    </div>
</div>