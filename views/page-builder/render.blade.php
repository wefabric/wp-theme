@php
	$debug = false;
@endphp

@foreach($blocks as $block)
    @if($block)
        @php
            $blockName = strConvert($block->get('acf_fc_layout'))->toKebab();

			$py = ''; //vertical padding for mobile
			$py_lg = ''; //vertical padding for desktop
			$px = ''; //horizontal padding

			if($block->get('sizes')) {
				switch($block->get('sizes')->get('height_mobile')) {
					case 'none'   : $py = 'py-0';  break;
					case 'small'  : $py = 'py-4';  break;
					case 'medium' : $py = 'py-8'; break;
					case 'large'  : $py = 'py-16'; break;
				}
				
				switch($block->get('sizes')->get('height_desktop')) {
					case 'none'   : $py_lg = 'lg:py-0';  break;
					case 'small'  : $py_lg = 'lg:py-8';  break;
					case 'medium' : $py_lg = 'lg:py-16'; break;
					case 'large'  : $py_lg = 'lg:py-24'; break;
				}
	
				//width (% of container) for desktop
				$width = $block->get('sizes')->get('width');
				if($width === 'nomargin') {
					$width = 'w-full';
				} else {
					$px = 'container px-4 md:px-8 lg:px-0';
				}
			}
			
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

        <div class="{{ $blockName }} @if(!empty($bg)) {{ $bg }} @endif text-{{ $block->get('text_color') ?? 'black' }}" @if(!empty($gradient)) style="{{ $gradient }}" @endif>
            <div class="{{ $px }} mx-auto {{ $py }} {{ $py_lg }} {{ $debug ? 'border-2 border-green-500' : '' }}">
                @if($debug) <p>Block: {{ $blockName }}</p> @endif
				
				<div class="mx-auto w-full lg:{{ $width }} {{ $debug ? 'border-2 border-pink-500' : '' }}">
					@include('page-builder.blocks.'. $blockName .'.index', ['block' => $block])
				</div>
            </div>
        </div>
    @endif
@endforeach