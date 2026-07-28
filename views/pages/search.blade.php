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
                    @php the_post(); @endphp
                    @template('components.post-content', 'search')
                @endwhile
                <div class="pagination text-center mt-12 lg:mt-24">
                    @php
                        the_posts_pagination([
                            'mid_size'           => 1,
                            'prev_next'          => false,
                            'screen_reader_text' => '',
                        ]);
                    @endphp
                </div>
            @else
                @template('components.post-content', 'none')
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchResultItems = document.querySelectorAll('.search-result-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const item = entry.target;

                        setTimeout(() => {
                            if (item.classList.contains('search-result-hidden')) {
                                item.classList.add('search-result-animated');
                                item.classList.remove('search-result-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(item);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            searchResultItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endsection