@php
    $packageTitle = $package['package_title'] ?? '';
    $packagePrice = $package['price'] ?? '';
    $packageLabel = $package['label'] ?? '';

//    @dd($packageLabel);



//    $activityThumbnailUrl = get_the_post_thumbnail_url($activity);
//    $activityTitle = get_the_title($activity);
//    $activityUrl = get_permalink($activity);
//
//    // Weergave
//    $visibleElements = $block['data']['show_element'] ?? [];
//    $activitySummary = get_the_excerpt($activity);
//    $activityCategories = get_the_category($activity);
@endphp

{{--<div class="activiteit-item group h-full">--}}
{{--    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">--}}
{{--        @if ($activityThumbnailUrl)--}}
{{--            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">--}}
{{--                <a href="{{ $activityUrl }}" class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>--}}
{{--                @if (!empty($visibleElements) && in_array('category', $visibleElements))--}}
{{--                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">--}}
{{--                        @foreach ($activityCategories as $category)--}}
{{--                            <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black">--}}
{{--                                {{ $category->name }}--}}
{{--                            </a>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if ($fields['activity_full'])--}}
{{--                    <div class="absolute z-20 top-[15px] right-[15px] bg-red-500 px-4 py-2 rounded-full text-white">--}}
{{--                        Vol--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <img src="{{ $activityThumbnailUrl }}" alt="{{ $activityTitle }}"--}}
{{--                     class="aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="w-full mt-5">--}}

{{--            <a href="{{ $activityUrl }}" class="font-bold text-lg group-hover:text-primary">{{ $activityTitle }}</a>--}}

{{--            <div class="activity-data mt-4">--}}
{{--                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($activitySummary))--}}
{{--                    <p class="mt-3 mb-3">{{ $activitySummary }}</p>--}}
{{--                @endif--}}

{{--                @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))--}}
{{--                    <p>--}}
{{--                        <i class="w-4 fas fa-map-marker-alt mr-3"></i>{{ $fields['location'] }}--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--                @if (!empty($visibleElements) && in_array('date', $visibleElements) && !empty($fields['date']))--}}
{{--                    <p>--}}
{{--                        <i class="w-4 fas fa-calendar-alt mr-3"></i>{{ $fields['date'] }}--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--                @if (!empty($visibleElements) && in_array('button', $visibleElements))--}}
{{--                    <div class="mt-4 flex items-center flex-wrap">--}}
{{--                        <a href="{{ $activityUrl }}" class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer--}}
{{--                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 group-hover:scale-110 transition duration-300 ease-in-out"--}}
{{--                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"--}}
{{--                                 stroke-linecap="round" stroke-linejoin="round">--}}
{{--                                <path d="M5 12h14"></path>--}}
{{--                                <path d="M12 5l7 7-7 7"></path>--}}
{{--                            </svg>--}}
{{--                        </a>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


<div class="p-4 w-full">
    <div class="h-full flex flex-col relative overflow-hidde bg-background-color">
        <div class="bg-secondary p-6">
            @if ($packageLabel)
                <span class="bg-primary text-white px-3 py-1text-xs absolute left-1/2 transform-x-1/2 top-0 ">{{ $packageLabel }}</span>
            @endif
            <h3 class="mb-1 font-medium">{{ $packageTitle }}</h3>
            <div class="flex items-center">
                <span>€ {{ $packagePrice }}</span>
                <span class="text-lg ml-1 font-normal text-gray-500">/mo</span>
            </div>
        </div>

        <div class="p-6">

            <p class="flex items-center text-gray-600 mb-2">
                                <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                     stroke-width="2.5"
                                     class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                                </span>Vexillologist pitchfork
            </p>
            <p class="flex items-center text-gray-600 mb-2">
                                <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                     stroke-width="2.5"
                                     class="w-3 h-3" viewBox="0 0 24 24">
                                    <path d="M20 6L9 17l-5-5"></path>
                                </svg>
                                </span>Tumeric plaid portland
            </p>
            <p class="flex items-center text-gray-600 mb-6">
                                <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                  <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                       stroke-width="2.5"
                                       class="w-3 h-3" viewBox="0 0 24 24">
                                      <path d="M20 6L9 17l-5-5"></path>
                                  </svg>
                                </span>Mixtape chillwave tumeric
            </p>
            <button class="flex items-center mt-auto text-white bg-gray-400 border-0 py-2 px-4 w-full focus:outline-none hover:bg-gray-500 rounded">
                Button
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                     stroke-width="2" class="w-4 h-4 ml-auto" viewBox="0 0 24 24">
                    <path d="M5 12h14M12 5l7 7-7 7"></path>
                </svg>
            </button>

            <p class="text-xs text-gray-500 mt-3">Literally you probably haven't heard of them jean shorts.</p>

        </div>
    </div>
</div>