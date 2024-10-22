@php
    $fields = get_fields($post);
    $postThumbnailId = get_post_thumbnail_id($post);
    $postTitle = get_the_title($post);
    $postUrl = get_permalink($post);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $postSummary = get_the_excerpt($post);
        $maxSummaryLength = 180;
        if (strlen($postSummary) > $maxSummaryLength) {
            $postSummary = substr($postSummary, 0, $maxSummaryLength - 3) . '...';
        }
    $postDate = get_the_date('j F, Y', $post);
    $postAuthorId = get_post_field('post_author', $post);
    $postAuthorName = get_the_author_meta('display_name', $postAuthorId);
    $postCategories = get_the_category($post);
@endphp

<div class="nieuws-item group h-full">
    <div class="news-wrapper relative h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($postThumbnailId)
            <div class="news-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="news-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($postCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                            @endphp
                            <a href="{{ $category->slug }}" style="background-color: {{ $categoryColor }}" class="news-category @if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full" aria-label="Ga naar {{ $category->name }}">
                                {!! $category->name !!}
                            </a>
                        @endforeach
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $postThumbnailId,
                    'size' => 'news-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $postTitle,
                ])
            </div>
        @endif
        <div class="news-data flex flex-col w-full grow mt-5">
            @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($postDate))
                <p class="news-post-date mb-2 text-{{ $newsTextColor }}">{{ $postDate }}</p>
            @endif

            <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina" class="news-title text-{{ $newsTitleColor }} font-bold text-lg group-hover:text-primary">{!! $postTitle !!}</a>

            <div class="news-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($postSummary))
                    <p class="news-summary text-{{ $newsTextColor }} mt-3 mb-2">{!! $postSummary !!}</p>
                @endif

                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))
                    <p class="news-author mt-4 text-{{ $newsTextColor }}">Geschreven door {!! $postAuthorName !!}</p>
                @endif
            </div>
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="news-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $postUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                           'icon' => $buttonCardIcon,
                        ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>