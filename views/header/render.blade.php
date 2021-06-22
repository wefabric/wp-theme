@foreach($blocks as $block)
    @if($block)
        <section class="{{ strConvert($block->get('acf_fc_layout'))->toKebab() }}">
            @include('header.blocks.'. strConvert($block->get('acf_fc_layout'))->toKebab() .'.index', ['block' => $block])
        </section>
    @endif
@endforeach