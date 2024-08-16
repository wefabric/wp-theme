@extends('layouts.main')

@section('content')
    <div class="page-builder">
        {!! apply_filters('the_content', get_post_field('post_content', $page->ID)) !!}
    </div>
@endsection
