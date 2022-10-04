@extends('layouts.main')

@section('content')
    @if($post && $post instanceof WP_Post)
        <div class="header">
            {!! themeHeader()->render($post->ID) !!}
        </div>

		@include('components.breadcrumbs.index', ['classes' => ''])

        <div class="page-builder">
            {!! pageBuilder()->render($post->ID) !!}
        </div>
    @endif
@endsection