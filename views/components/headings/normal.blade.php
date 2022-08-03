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

@if($show_line) {{-- Hier wordt er zo'n heel leuk stylistisch lijntje boven de titel geprint in dezelfde kleur als de tekst. --}}
    <span class="w-[77px] h-[2px] bg-{{ $text_color ?? 'white'}}"></span>
@endif

<{{$hx}} @if($id ?? '') id="{{ $id }}" @endif
    class="font-head inline-block align-text-top z-10 {{ $class ?? '' }} text-{{ $text_color ?? '' }}">
    {{ $heading }}
</{{$hx}}>

@if(!empty($title) && !empty($title->get('subtitle')))
    @include('components.content', [
	    'content' => $title->get('subtitle'),
    ])
@endif