@php
    $fields = get_fields($vacancy);

    $vacancyThumbnailUrl = get_the_post_thumbnail_url($vacancy);
    $vacancyTitle = get_the_title($vacancy);
    $vacancyUrl = get_permalink($vacancy);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $vacancySummary = $fields['excerpt'] ?? '';
    $vacancyCategories = get_the_category($vacancy);
@endphp

<div class="vacature-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($vacancyThumbnailUrl)
            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $vacancyUrl }}"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($vacancyCategories as $category)
                            <a href="{{ $category->slug }}" class="bg-secondary px-4 py-2 rounded-full text-black">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
                <img src="{{ $vacancyThumbnailUrl }}" alt="{{ $vacancyTitle }}"
                     class="aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110">
            </div>
        @endif
        <div class="w-full mt-5">

            <a href="{{ $vacancyUrl }}" class="font-bold text-lg group-hover:text-primary">{{ $vacancyTitle }}</a>

            <div class="vacancy-data mt-4">

                @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))
                    <p>
                        <i class="w-4 object-cover fas fa-map-marker-alt mr-3"></i>{{ $fields['location'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('working_hours', $visibleElements) && !empty($fields['working_hours']))
                    <p class="capitalize">
                        <i class="w-4 object-cover fas fa-clock mr-2 mr-3"></i>{{ $fields['working_hours'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('salary', $visibleElements) && !empty($fields['salary']))
                    <p>
                        <i class="w-4 fas fa-money-bill-simple-wave mr-3"></i>{{ $fields['salary'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($vacancySummary))
                    <p class="mt-3 mb-3">{{ $vacancySummary }}</p>
                @endif

                @if (!empty($visibleElements) && in_array('button', $visibleElements))
                    <div class="mt-4 flex items-center flex-wrap">
                        <a href="{{ $vacancyUrl }}" class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer
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