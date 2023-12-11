{{--
	Use this class to display one heading, e.g. an H1-H6 tag.
	Want to display a collection of headings (a title followed by a subtitle)? Use 'headings.collection' to display each heading with this class automatically.
	For the required tags, see the example in 'headings.collection'.
--}}

@php
    $hx = $type ?? 'h3';
	if(is_numeric($hx)) {
		$hx = 'h'. $hx; //in case someone sends e.g. '2' instead of 'h2'.
	}
	
    if(!empty($title)) {
		if(empty($heading) && !empty($title->get('title'))) {
			$heading = $title->get('title');
		}

		if(!empty($title->get('title_color'))) {
			$title_color = $title->get('title_color');
		}
		
		if(!empty($title->get('title_align'))) {
			$title_align = $title->get('title_align');
		}
    }
	
	if(!empty($title_color) && !str_starts_with($title_color, 'text-')) {
		$title_color = 'text-'. $title_color;
	}
	if(!empty($title_align) && !str_starts_with($title_align, 'text-')) {
		$title_align = 'text-'. $title_align;
	}
	
	$display = '';
	if(!empty($display_type_mobile)) {
		$display .= $display_type_mobile;
	}
	if(!empty($display_type_desktop)) {
		if(!empty($display_type_mobile) && $display_type_mobile == 'hidden') {
			$display .= ' lg:block'; //to unset the mobile hidden.
		}
		$display .= ' lg:'. $display_type_desktop;
	}
@endphp

@if(!empty($heading))
	<{{$hx}} @if($id ?? '') id="{{ $id }}" @endif
		class="{{ $display }} inline-block w-full align-text-top z-10 {{ $class ?? 'pb-4 lg:pb-8' }} {{ $title_color ?? '' }} {{ $title_align ?? '' }} ">
		{!! $heading !!}
	</{{$hx}}>
	
	{{-- Doesn't get used a lot anymore, since the title repeater block already provides for a separate 'subtitle' entry to follow this 'title'. --}}
	@if(!empty($title) && !empty($title->get('subtitle')))
		@include('components.content', [
			'content' => $title->get('subtitle'),
			'class' => $subtitle_class ?? $class ?? 'pb-4 lg:pb-8 ',
		])
	@endif
@endif