{{--
	Use this class to display a collection of headings (a title followed by a subtitle) using 'headings.normal' for each heading..
	Want to display one heading, e.g. an H1-H6 tag? Use 'headings.normal' directly.
--}}

@foreach($title->get('titles') as $heading)
	@include('components.headings.normal', [
		'type' => $heading->get('type'),
		'heading' => $heading->get('text'),
		'display_type' => $heading->get('display_type'),
		'title_align' => $heading->get('align'),
		'title_color' => $title->get('title_color'),
	])
@endforeach