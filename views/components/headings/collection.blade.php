{{--
	Use this class to display a collection of headings (a title followed by a subtitle) using 'headings.normal' for each heading..
	Want to display one heading, e.g. an H1-H6 tag? Use 'headings.normal' directly.
--}}

@php
	if(!isset($titles)) {
		$titles = $title->get('titles');
	}
@endphp

@foreach($titles as $heading)
	@include('components.headings.normal', [
		'type' => $heading->get('type'),
		'heading' => $heading->get('text'),
		'display_type_mobile' => $heading->get('display_type_mobile'),
		'display_type_desktop' => $heading->get('display_type_desktop'),
		'title_align' => $heading->get('align'),
		'title_color' => $title_color ?? $title->get('title_color'),
		'class' => ($loop->last && ($disable_bottom_padding ?? false)) ? '' : ($class ?? 'pb-4 lg:pb-8'),
	]) {{-- don't give the last title any bottom-padding --}}
@endforeach