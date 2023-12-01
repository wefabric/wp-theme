@php
    $fields = get_fields($vacancy);
    $vacancyThumbnailID = get_post_thumbnail_id($vacancy);
    $vacancyTitle = get_the_title($vacancy);
    $vacancyUrl = get_permalink($vacancy);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $vacancySummary = $fields['excerpt'] ?? '';
    $vacancyCategories = get_the_category($vacancy);
@endphp

<div class="vacature-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($vacancyThumbnailID)
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
                @include('components.image', [
                   'image_id' => $vacancyThumbnailID,
                   'size' => 'full',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $vacancyTitle,
           ])
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
                        <i class="w-4 object-cover fas fa-clock mr-3"></i>{{ $fields['working_hours'] }}
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
                    @if ($buttonCardText)
                        <div class="mt-auto relative z-20 flex items-center">
                            @include('components.buttons.default', [
                               'text' => $buttonCardText,
                               'href' => $vacancyUrl,
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
</div>