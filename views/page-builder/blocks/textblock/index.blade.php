@php
    if($block->get('title')->get('show_separate_title')) {
        $title = $block->get('title');
        switch($title->get('title_position')) { //based on the textblock
            case 'above':
                $div_class = 'flex-col';
                $title_class = 'order-1';
                $text_class = 'order-2';
                break;
            case 'left':
                $div_class = 'flex-row';
                $title_class = 'lg:w-1/2 order-1';
                $text_class = 'lg:w-1/2 order-2';
                break;
            case 'right':
                $div_class = 'flex-row';
                $title_class = 'lg:w-1/2 order-2';
                $text_class = 'lg:w-1/2 order-1';
                break;
            case 'below':
                $div_class = 'flex-col';
                $title_class = 'order-2';
                $text_class = 'order-1';
                break;
        }
    } else {
        $div_class = '';
        $title_class = '';
        $text_class = '';
    }
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }} flex flex-col lg:{{ $div_class }} gap-2 text-{{ $block->get('text_color') }}  flex">
	@if($block->get('title')->get('show_separate_title'))
		<div class="{{ $title_class }} text-{{$title->get('title_align')}}">
			@include('components.headings.normal', [
				'type' => 2,
				'title' => $title,
			])
		</div>
	@endif
	
    <div class="{{ $text_class }} flex flex-col lg:{{ $block->get('text_width') }}">
        <div class=" {{ '' ?? 'py-4 lg:py-8' }}">
            @include('components.content', [
                'content' => apply_filters('the_content', $block->get('text')),
                'class' => 'text-'. $block->get('text_align'),
            ])
        </div>
		
		@if($block->get('buttons')->get('show_button'))
			<div class="flex pt-6 justify-{{ $block->get('buttons')->get('justify') }}">
				@foreach($block->get('buttons')->get('buttons') as $button)
					@include('components.buttons.default', [
						'button' => $button,
						'class' => 'disable-chevron font-bold',
						'a_class' => 'px-4',
					])
				@endforeach
			</div>
		@endif
		
    </div>
</div>
