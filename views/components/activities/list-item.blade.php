@php
    $fields = get_fields($activity);

    $activityThumbnailUrl = get_the_post_thumbnail_url($activity);
    $activityTitle = get_the_title($activity);
    $activityUrl = get_permalink($activity);

     // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $activitySummary = get_the_excerpt($activity);
    $activityCategories = get_the_category($activity);
@endphp

<div class="activiteit-item group cursor-pointer h-full" onclick="window.location.href = '{{ $activityUrl }}';">
    <div class="h-full flex flex-col items-center border-2 border-gray-200 border-opacity-60 group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($activityThumbnailUrl)
            <div class="h-[360px] overflow-hidden w-full relative">
                <div class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></div>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($activityCategories as $category)
                            <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black mb-2">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                @if ($fields['activity_full'])
                    <div class="absolute z-20 top-[15px] right-[15px] bg-red-500 px-4 py-2 rounded-full text-white">Vol</div>
                @endif
                <img src="{{ $activityThumbnailUrl }}" alt="Featured Image" class="w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">
            </div>
        @endif
        <div class="w-full mt-4 mb-2 p-3 md:p-4">

            <p class="font-bold text-lg">{{ $activityTitle }}</p>

            <div class="activity-data mt-4">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($activitySummary))
                    <p class="mt-3 mb-3">{{ $activitySummary }} </p>
                @endif

                @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))
                    <p class="">
                        <i class="fas fa-map-marker-alt mr-2"></i>{{ $fields['location'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($fields['date']))
                    <p class="">
                        <i class="fas fa-calendar-alt mr-2"></i>{{ $fields['date'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('button', $visibleElements))
                    <div class="mt-4 flex items-center flex-wrap">
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
</div>