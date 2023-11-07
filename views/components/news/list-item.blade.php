@php
    $fields = get_fields($post);
    $postThumbnailId = get_post_thumbnail_id($post);
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
        @if ($postThumbnailId)
            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $postUrl }}"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($postCategories as $category)
                            <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $postThumbnailId,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $postTitle,
            ])
            </div>
        @endif
        <div class="w-full mt-5">
            @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($postDate))
                <p class="text-gray-500">{{ $postDate }}</p>
            @endif

            <a href="{{ $postUrl }}" class="font-bold text-lg group-hover:text-primary">{{ $postTitle }}</a>

            <div class="news-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($postSummary))
                    <p class="mt-3 mb-2">{{ $postSummary }} </p>
                @endif

                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))
                    <p class="text-gray-500">Geschreven door {{ $postAuthorName }}</p>
                @endif

                @if (!empty($visibleElements) && in_array('button', $visibleElements))
                    @if ($buttonCardText)
                        <div class="mt-4 md:mt-8 z-10">
                            @include('components.buttons.default', [
                               'text' => $buttonCardText,
                               'href' => $postUrl,
                               'alt' => $buttonCardText,
                               'colors' => 'btn btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle . '',
                               'class' => 'rounded-lg',
                           ])
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>