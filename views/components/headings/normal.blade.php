@php
    $hx = 'h'. ($type ?? '3');

    if(!empty($title)) {
		if(empty($heading) && !empty($title->get('title'))) {
			$heading = $title->get('title');
		}

		if(!empty($title->get('text_color'))) {
			$text_color = $title->get('text_color');
		}
    }
@endphp

<{{$hx}} @if($id ?? '') id="{{ $id }}" @endif
    class="font-head inline-block align-text-top z-10 pb-4 lg:pb-8 {{ $class ?? '' }} text-{{ $text_color ?? '' }}">
    {!! $heading !!}
</{{$hx}}>

@if(!empty($title) && !empty($title->get('subtitle')))
    @include('components.content', [
	    'content' => $title->get('subtitle'),
	    'class' => $subtitle_class ?? ' pb-4 lg:pb-8 ',
    ])
@endif