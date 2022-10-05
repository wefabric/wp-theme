@php
	$debug = false;
@endphp

@foreach($blocks as $block)
    @if($block)
        @php
            $blockName = strConvert($block->get('acf_fc_layout'))->toKebab();

            $bg = '';
            $gradient = '';
            if($block->get('bg_color')) {
                if($block->get('bg_color_2')) { //gradient
                    $from = color_to_rgba($block->get('bg_color'));
                    $to = color_to_rgba($block->get('bg_color_2'));
                    $gradient = 'background: linear-gradient(180deg, '. $from .' 0%, '. $from .' 50%, '. $to .' 50%, '. $to .' 100%);';
                } else { //solid bg.
                    $bg = 'bg-'. $block->get('bg_color');
                }
            }
        @endphp

        <div class="@if(!empty($bg)) {{ $bg }} @endif text-{{ $block->get('text_color') ?? 'black' }}" @if(!empty($gradient)) style="{{ $gradient }}" @endif>
            <div class="@if($block->get('width') !== 'nomargin') px-4 md:px-8 xl:px-0 @endif py-16 lg:py-24 {{ $debug ? 'border-2 border-green-500' : '' }}">
                @if($debug) <p>Block: {{ $blockName }} @endif
                <section class="{{ $blockName }} @if($block->get('width') !== 'nomargin') container @endif mx-auto {{ $debug ? 'border-2 border-pink-500' : ''}} ">
                    @include('page-builder.blocks.'. $blockName .'.index', ['block' => $block])
                </section>
            </div>
        </div>
    @endif
@endforeach