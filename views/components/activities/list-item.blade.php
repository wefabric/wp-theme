@php
    $fields = get_fields($activity);
    $activityThumbnailID = get_post_thumbnail_id($activity);
    $activityTitle = get_the_title($activity);
    $activityUrl = get_permalink($activity);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $activitySummary = get_the_excerpt($activity);
    $activityCategories = get_the_category($activity);

    // Sort dates array based on date
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
@endphp

<div class="activiteit-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($activityThumbnailID)
            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $activityUrl }}" aria-label="Ga naar {{ $activityTitle }}"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if ($fields['activity_full'])
                    <a href="{{ $activityUrl }}" aria-label="Ga naar {{ $activityTitle }}"
                       class="absolute w-full h-full bg-white z-10 opacity-70 transition-opacity"></a>
                @endif
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($activityCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                            @endphp
                            <a href="{{ $category->slug }}" style="background-color: {{ $categoryColor }}" class="@if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full" aria-label="Ga naar {{ $category->name }}">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                @if ($fields['activity_full'])
                    <div class="absolute z-20 top-[15px] right-[15px] bg-red-500 px-4 py-2 rounded-full text-white">
                        Vol
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $activityThumbnailID,
                    'size' => 'job-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $activityTitle,
            ])
            </div>
        @endif
        <div class="flex flex-col w-full grow mt-5">

            <a href="{{ $activityUrl }}" aria-label="Ga naar {{ $activityTitle }}" class="font-bold text-{{ $activityTitleColor }} text-lg group-hover:text-primary">{{ $activityTitle }}</a>

            <div class="activity-data mt-4 text-{{ $activityTextColor }}">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($activitySummary))
                    <p class="mt-3 mb-3">{{ $activitySummary }}</p>
                @endif

                @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))
                    <p class="flex items-baseline leading-[1.5]">
                        <i class="w-4 fas fa-map-marker-alt mr-3 inline flex-shrink-0"></i>
                        {{ $fields['location'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($fields['dates']))
                    <p class="flex items-baseline leading-[1.5]">
                        <i class="w-4 fas fa-calendar-alt mr-3"></i>
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

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $activityUrl,
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