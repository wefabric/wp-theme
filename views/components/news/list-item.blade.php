@php
    $fields = get_fields($post);

    $postThumbnailUrl = get_the_post_thumbnail_url($post);
    $postTitle = get_the_title($post);
    $postUrl = get_permalink($post);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $postSummary = get_the_excerpt($post);
    $postDate = get_the_date('j F, Y', $post);
    $postAuthorId = get_post_field('post_author', $post);
    $postAuthorName = get_the_author_meta('display_name', $postAuthorId);
    $postCategories = get_the_category($post);
@endphp

<div class="nieuws-item group h-full">
    <div class="h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">

            @if ($postThumbnailUrl)
                <div class="h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                    <a href="{{ $postUrl }}" class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                    @if (!empty($visibleElements) && in_array('category', $visibleElements))
                        <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($postCategories as $category)
                                <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                    <img src="{{ $postThumbnailUrl }}" alt="Featured Image"
                         class="w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">
                </div>
            @endif
        <div class="w-full mt-5">
            @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($postDate))
                <p class="text-gray-500">{{ $postDate }}</p>
            @endif

            <a href="{{ $postUrl }}" class="font-bold text-lg">{{ $postTitle }}</a>

            <div class="news-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($postSummary))
                    <p class="mt-3 mb-2">{{ $postSummary }} </p>
                @endif

                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))
                    <p class="text-gray-500">Geschreven door {{ $postAuthorName }}</p>
                @endif

                @if (!empty($visibleElements) && in_array('button', $visibleElements))
                    <div class="mt-4 flex items-center flex-wrap">
                        <a href="{{ $postUrl }}" class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 group-hover:scale-110 transition duration-300 ease-in-out"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>