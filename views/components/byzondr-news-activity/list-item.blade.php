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

     // Sort dates array based on date
    if (!empty($fields)) {
        if (!empty($fields['dates'])) {
            usort($fields['dates'], function ($a, $b) {
                $dateA = DateTime::createFromFormat('d/m/Y', $a['date']);
                $dateB = DateTime::createFromFormat('d/m/Y', $b['date']);

                // If dates are the same, compare start times
                if ($dateA == $dateB) {
                    $startTimeA = DateTime::createFromFormat('H:i', $a['start_time']);
                    $startTimeB = DateTime::createFromFormat('H:i', $b['start_time']);

                    return $startTimeA <=> $startTimeB;
                }
                return $dateA <=> $dateB;
            });
        }
    }
@endphp

<div class="nieuws-item group h-full">
    <div class="h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($postThumbnailId)
            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($postCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                            @endphp
                            <a href="{{ $category->slug }}" style="background-color: {{ $categoryColor }}"
                               class="@if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full"
                               aria-label="Ga naar {{ $category->name }}">
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
        <div class="flex flex-col w-full grow mt-5">
            @if (!empty($visibleElements) && in_array('written_date', $visibleElements) && !empty($postDate))
                <p class="mb-2 text-{{ $newsTextColor }}">{{ $postDate }}</p>
            @endif

            <a href="{{ $postUrl }}" aria-label="Ga naar {{ $postTitle }} pagina"
               class="text-{{ $newsTitleColor }} font-bold text-lg group-hover:text-primary">{{ $postTitle }}</a>

            <div class="news-info">

                @if (!empty($fields) && !empty($fields['activity']))
                    <div class="activity-info">
                        @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))
                            <p class="mt-3 flex items-baseline leading-[1.5] text-{{ $newsTextColor }} font-bold">
                                <i class="w-4 fas fa-map-marker-alt mr-3 inline flex-shrink-0 text-secondary"></i>
                                {{ $fields['location'] }}
                            </p>
                        @endif

                        @if (!empty($visibleElements) && in_array('access', $visibleElements))
                            <p class="flex items-baseline leading-[1.5] text-{{ $newsTextColor }} font-bold">
                                <i class="w-4 fas fa-user mr-3 inline flex-shrink-0 text-secondary"></i>
                                {{ $fields['access'] === 'public' ? 'Iedereen' : ($fields['access'] === 'private' ? 'Besloten' : $fields['access']) }}
                            </p>
                        @endif

                        @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($fields['dates']))
                            <p class="flex items-baseline leading-[1.5] text-{{ $newsTextColor }} font-bold">
                                <i class="w-4 fas fa-calendar-alt mr-3 text-secondary"></i>
                                @foreach ($fields['dates'] as $date)
                                    {{ ($date['date']) }}

                                    @if (!empty($visibleElements) && in_array('time', $visibleElements) && !empty($date['start_time']))
                                        van {{ ($date['start_time']) }}
                                        @if ($date['end_time'])
                                            tot {{ ($date['end_time']) }}
                                        @endif
                                    @endif
                                    <br>
                                @endforeach
                            </p>
                        @endif
                    </div>
                @endif

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($postSummary))
                    <p class="text-{{ $newsTextColor }} mt-3 mb-2">{{ $postSummary }} </p>
                @endif

                @if (!empty($visibleElements) && in_array('author', $visibleElements) && !empty($postAuthorName))
                    <p class="mt-4 text-{{ $newsTextColor }}">Geschreven door {{ $postAuthorName }}</p>
                @endif
            </div>
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $postUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                       ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>