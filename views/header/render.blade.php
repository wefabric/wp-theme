@foreach($blocks as $block)
    @if($block)
        @php
            $blockName = strConvert($block->get('acf_fc_layout'))->toKebab();
        @endphp

        <section class="{{ $blockName }}">
            @include('header.blocks.'. $blockName .'.index', ['block' => $block])
        </section>
    @endif
@endforeach