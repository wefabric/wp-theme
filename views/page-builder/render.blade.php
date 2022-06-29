@foreach($blocks as $block)
    @if($block)
        @php
            $blockName = strConvert($block->get('acf_fc_layout'))->toKebab();
        @endphp

        <div class="px-8 lg:px-0">
            <section class="{{ $blockName }} py-12 container mx-auto">
                @include('page-builder.blocks.'. $blockName .'.index', ['block' => $block])
            </section>
        </div>
    @endif
@endforeach