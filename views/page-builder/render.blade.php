@php
    if(!function_exists('color_to_rgba')) {
        function color_to_rgba (string $color)
        {
            switch($color) {
                case 'white':
                    return 'rgba(255,255,255,1)';
                case 'black':
                    return 'rgba(0,0,0,1)';
                case 'primary-color':
                    return 'rgba(7, 75, 52, 1)';
                case 'primary-color-light':
                    return 'rgba(58, 186, 101, 1)';
                case 'primary-color-dark':
                    return 'rgba(5, 57, 39, 1)';
            }
            dump('undefined gradient color (pagebuilder.render): '. $color);
            return $color; //fallback
        }
    }

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
            <div class="px-8 lg:px-0 pb-20">
                @if($debug) <p>Block: {{ $blockName }} @endif
                <section class="{{ $blockName }} @if($block->get('width') !== 'nomargin') container @endif mx-auto {{ $debug ? 'border-2 border-pink-500' : ''}} ">
                    @include('page-builder.blocks.'. $blockName .'.index', ['block' => $block])
                </section>
            </div>
        </div>
    @endif
@endforeach