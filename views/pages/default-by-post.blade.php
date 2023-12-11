@extends('layouts.main')

@section('content')
    @if($post && $post instanceof WP_Post)
        <div class="page-builder">
            {!! apply_filters('the_content', get_post_field('post_content', $post)); !!}
        </div>
    @endif
@endsection