<article id="post-{{ Loop::id() }}" class="group search-result-item grid grid-cols-2 gap-x-16 mt-8" {!! post_class() !!}>
    <div class="w-full h-auto h-[300px]">
        <a href="{{ esc_url(get_permalink()) }}" rel="bookmark" class="h-full w-full">
            @if(has_post_thumbnail())
                {!! the_post_thumbnail('full', [
                    'style' => 'height: 100%; width: 100%; object-fit: cover;'
                ]) !!}
                @else
                <div class="h-full w-full bg-primary"></div>
            @endif
        </a>
    </div>
    <div>
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
