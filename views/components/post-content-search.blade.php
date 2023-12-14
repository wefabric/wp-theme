<article id="post-{{ Loop::id() }}" class="grid grid-cols-2 gap-x-16 mt-8" {!! post_class() !!}>
    <div class="">
        {!! the_post_thumbnail('small') !!}
    </div>
    <div>
        <h2 class="entry-title">
            <a href="{{ esc_url(get_permalink()) }}" rel="bookmark">{!! Loop::title() !!}</a>
        </h2>
        @if('post' === get_post_type())
            <div class="entry-meta">
                {!! posted_on() !!}
                {!! posted_by() !!}
            </div>
        @endif
        <div class="entry-summary">
            {!! Loop::excerpt() !!}
        </div>
    </div>
</article>
