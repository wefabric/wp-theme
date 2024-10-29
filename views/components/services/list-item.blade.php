@php
    $fields = get_fields($service);
    $serviceThumbnailId = get_post_thumbnail_id($service);
    $serviceTitle = get_the_title($service);
    $serviceUrl = get_permalink($service);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $serviceSummary = get_the_excerpt($service);
        $maxSummaryLength = 180;
        if (strlen($serviceSummary) > $maxSummaryLength) {
            $serviceSummary = substr($serviceSummary, 0, $maxSummaryLength - 3) . '...';
        }

    $serviceCategories = get_the_terms($service, 'division_categories');
@endphp

<div class="service-item group h-full">
    <div class="service-wrapper relative h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($serviceThumbnailId)
            <div class="service-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $serviceUrl }}" aria-label="Ga naar {{ $serviceTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="service-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($serviceCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                                $categoryIcon = get_field('category_icon', $category);
                            @endphp
                            <div style="background-color: {{ $categoryColor }}" class="service-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                                {!! $categoryIcon !!} {!! $category->name !!}
                            </div>
                        @endforeach
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $serviceThumbnailId,
                    'size' => 'news-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $serviceTitle,
            ])
            </div>
        @endif
        <div class="service-data flex flex-col w-full grow mt-5">

            <a href="{{ $serviceUrl }}" aria-label="Ga naar {{ $serviceTitle }} pagina"
               class="service-title text-{{ $serviceTitleColor }} font-bold text-lg group-hover:text-primary">{!! $serviceTitle !!}</a>

            <div class="service-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($serviceSummary))
                    <p class="service-summary text-{{ $serviceTextColor }} mt-3 mb-2">{{ $serviceSummary }} </p>
                @endif
            </div>
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $serviceUrl,
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