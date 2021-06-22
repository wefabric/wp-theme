@extends('layouts.main')

@section('content')
    @if(have_posts())
        <header class="page-header">
            <h1 class="page-title">{!! sprintf(esc_html__('Search Results for: %s', THEME_TD), '<span>'.get_search_query().'</span>') !!}</h1>
        </header>
        @while(have_posts())
            @php(the_post())
            @template('components.post-content', 'search')
        @endwhile
        {!! get_the_posts_navigation() !!}
    @else
        @template('components.post-content', 'none')
    @endif
@endsection