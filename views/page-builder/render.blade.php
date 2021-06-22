@foreach($blocks as $block)
    @if($block)
        <section class="{{ strConvert($block->get('acf_fc_layout'))->toKebab() }} py-12">
            @include('page-builder.blocks.'.strConvert($block->get('acf_fc_layout'))->toKebab().'.index', ['block' => $block])
        </section>
    @endif
@endforeach