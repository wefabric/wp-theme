@extends('layouts.main')

@section('content')
    @if($post && $post instanceof WP_Post)
        <div class="page-builder">
            {!! apply_filters('the_content', get_post_field('post_content', $post)); !!}
        </div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 container mx-auto">
        <div class="w-full lg:w-4/5 text-left justify-start mx-auto">

            @if(have_posts())
                @while(have_posts())
                    @php(the_post())
                    @template('components.post-content', 'search')
                @endwhile
                <div class="search-result-nav flex flex-row">
                    {!! get_the_posts_navigation() !!}
                </div>
            @else
                @template('components.post-content', 'none')
            @endif
        </div>
    </div>
@endsection