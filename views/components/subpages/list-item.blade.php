@php
    $fields = get_fields($subpage);
    $subpageThumbnailId = get_post_thumbnail_id($subpage);
    $subpageTitle = get_the_title($subpage);
    $subpageUrl = get_permalink($subpage);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];

    $subpageSummary = get_the_excerpt($subpage);
    $shortenSummary = $block['data']['shorten_excerpt'] ?? false;
    if ($shortenSummary) {
        $maxSummaryLength = $block['data']['max_summary_length'] ?? 180;
        if (strlen($subpageSummary) > $maxSummaryLength) {
            $subpageSummary = substr($subpageSummary, 0, $maxSummaryLength - 3) . '...';
        }
    }

    $subpageCategories = get_the_terms($subpage, 'category');

    $pageLink = $block['data']['page_url'] ?? false;
@endphp

<div class="subpage-item group h-full">
    <div class="subpage-wrapper relative h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($subpageThumbnailId)
            <div class="subpage-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                @if ($pageLink)
                <a href="{{ $subpageUrl }}" aria-label="Ga naar {{ $subpageTitle }} pagina"
                   class="overlay left-0 top-0 absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @endif
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="subpage-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($subpageCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                                $categoryIcon = get_field('category_icon', $category);
                                $categoryImage = get_field('category_image', $category);
                            @endphp
                            <div style="background-color: {{ $categoryColor }}" class="subpage-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                @if($categoryImage)
                                    <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                                @endif
                                {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $subpageThumbnailId,
                    'size' => 'news-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $subpageTitle,
                ])
            </div>
        @endif
        <div class="subpage-data flex flex-col w-full grow mt-5">
            @if ($pageLink)
            <a href="{{ $subpageUrl }}" aria-label="Ga naar {{ $subpageTitle }} pagina"
               class="subpage-title text-{{ $subpageTitleColor }} font-bold text-lg group-hover:text-primary">{!! $subpageTitle !!}</a>
            @else
                <div class="subpage-title text-{{ $subpageTitleColor }} font-bold text-lg">{!! $subpageTitle !!}</div>
            @endif
            <div class="subpage-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($subpageSummary))
                    <p class="subpage-summary text-{{ $subpageTextColor }} mt-3 mb-2">{{ $subpageSummary }} </p>
                @endif
            </div>
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $subpageUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg text-left',
                       ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>