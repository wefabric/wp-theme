<article id="post-{{ Loop::id() }}" class="group search-result-item flex flex-col md:flex-row gap-y-4 gap-x-8 mt-16 md:mt-8" {!! post_class() !!}>
    <div class="w-full md:w-1/2 h-[280px] relative overflow-hidden">

        @if(has_post_thumbnail())
            {!! the_post_thumbnail('full', [
                'style' => 'height: 100%; width: 100%; object-fit: cover;'
            ]) !!}

            @else
            <div class="h-full w-full bg-primary"></div>
        @endif

        <a href="{{ esc_url(get_permalink()) }}" rel="bookmark" class="h-full w-full">
            <div class="overlay pointer-events-none absolute inset-0 w-full h-full bg-primary opacity-0 group-hover:opacity-50 transition-all duration-300 ease-in-out"></div>
        </a>
    </div>
    <div class="w-full md:w-1/2">
        <h2 class="entry-title text-[24px]">
            <a class="group-hover:text-primary" href="{{ esc_url(get_permalink()) }}" rel="bookmark">{!! Loop::title() !!}</a>
        </h2>
        @if('post' === get_post_type())
            <div class="entry-meta">
{{--                {!! posted_on() !!}--}}
{{--                {!! posted_by() !!}--}}
            </div>
        @endif
        <div class="entry-summary">
            {!! Loop::excerpt() !!}
        </div>
    </div>
</article>
