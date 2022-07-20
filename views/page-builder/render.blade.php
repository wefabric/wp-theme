@foreach($blocks as $block)
    @if($block)
        @php
            $blockName = strConvert($block->get('acf_fc_layout'))->toKebab();
        @endphp

        <div class="px-8 lg:px-0 pb-8">
            <p>Block: {{ $blockName }}</p> {{-- <<    DEBUG REMOVE      v         v     --}}
            <section class="{{ $blockName }} py-12 container mx-auto  border-2 border-black ">
                @include('page-builder.blocks.'. $blockName .'.index', ['block' => $block])
            </section>
        </div>
    @endif
@endforeach