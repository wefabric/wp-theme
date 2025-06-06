@php
    $fields = get_fields($vacancy);
    $vacancyThumbnailID = get_post_thumbnail_id($vacancy);
    $vacancyTitle = get_the_title($vacancy);
    $vacancyUrl = get_permalink($vacancy);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $vacancySummary = $fields['excerpt'] ?? '';
    $vacancyCategories = get_the_terms($vacancy, 'vacature_categories');

     if (!empty($visibleElements) && in_array('working_hours', $visibleElements) && !empty($fields['working_hours'])) {
        switch ($fields['working_hours']) {
            case 'parttime':
                $workingHours = 'Parttime';
                break;
            case 'fulltime':
                $workingHours = 'Fulltime';
                break;
            case 'both':
                $workingHours = 'Parttime en fulltime';
                break;
            default:
                $workingHours = '';
                break;
        }
    }
@endphp

<div class="vacature-item group h-full @if ($flyinEffect) vacancy-hidden @endif">
    <div class="h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($vacancyThumbnailID)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $vacancyUrl }}" aria-label="Ga naar {{ $vacancyTitle }} pagina"
                   class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($vacancyCategories && !is_bool($vacancyCategories))
                        <div class="vacature-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($vacancyCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="vacature-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $vacancyThumbnailID,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $vacancyTitle,
                ])
            </div>
        @endif
        <div class="vacature-content flex flex-col w-full grow mt-5">

            <a href="{{ $vacancyUrl }}" aria-label="Ga naar {{ $vacancyTitle }} pagina" class="vacancy-title-text font-bold text-{{ $vacancyTitleColor }} text-lg group-hover:text-primary">{!! $vacancyTitle !!}</a>

            <div class="vacancy-data mt-4 text-{{ $vacancyTextColor }}">

                @if (!empty($visibleElements) && in_array('location', $visibleElements) && !empty($fields['location']))
                    <p class="flex items-baseline leading-[1.5]">
                        <i class="w-4 object-cover fas fa-map-marker-alt mr-3"></i>
                        {{ $fields['location'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('working_hours', $visibleElements) && !empty($fields['working_hours']))
                    <p class="flex items-baseline leading-[1.5]">
                        <i class="w-4 object-cover fas fa-clock mr-3"></i>
                        {{ $workingHours }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('salary', $visibleElements) && !empty($fields['salary']))
                    <p class="flex items-baseline leading-[1.5]">
                        <i class="w-4 fas fa-money-bill-simple-wave mr-3"></i>
                        {{ $fields['salary'] }}
                    </p>
                @endif

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($vacancySummary))
                    <p class="mt-3 mb-3">{{ $vacancySummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="vacancy-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $vacancyUrl,
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