@extends('layouts.main')

@section('content')
    @if($post && $post instanceof WP_Post)
        <div class="header">
            {!! themeHeader()->render($post->ID) !!}
        </div>

        <div class="container mx-auto px-8 lg:px-0">
            @include('components.breadcrumbs.index', ['classes' => ''])
        </div>

        <div class="page-builder">
            {!! pageBuilder()->render($post->ID) !!}
        </div>
    @endif
@endsection