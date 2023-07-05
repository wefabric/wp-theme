@php
    $fields = get_fields($post);

    $postThumbnailUrl = get_the_post_thumbnail_url($post);
    $postTitle = get_the_title($post);
    $postUrl = get_permalink($post);

    $visibleElements = $block['data']['show_element'] ?? [];

    $postSummary = get_the_excerpt($post);
    $postDate = get_the_date('j F, Y', $post);
    $postAuthorId = get_post_field('post_author', $post);
    $postAuthorName = get_the_author_meta('display_name', $postAuthorId);
@endphp

<div class="nieuws-item group cursor-pointer" onclick="window.location.href = '{{ $postUrl }}';">
    <div class="h-full flex flex-col items-center border-2 border-gray-200 border-opacity-60 group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($postThumbnailUrl)
            <div class="h-56 md:h-80 overflow-hidden w-full relative">
                <div class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></div>
                <img src="{{ $postThumbnailUrl }}" alt="Featured Image" class="w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">

            </div>
        @endif
        <div class="w-full mt-4 mb-2 p-3 md:p-4">
            @if (!empty($visibleElements) && in_array('date', $visibleElements))
                <p class="text-gray-500">{{ $postDate }}</p>
            @endif

            <p class="font-bold text-lg">{{ $postTitle }}</p>


            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))
                <p class="mt-3 mb-2">{{ $postSummary }} </p>
            @endif

            @if (!empty($visibleElements) && in_array('author', $visibleElements))
                <p class="text-gray-500">Geschreven door {{ $postAuthorName }}</p>
            @endif

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                <div class="flex items-center flex-wrap">

                    <a class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 group-hover:scale-110 transition duration-300 ease-in-out" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>