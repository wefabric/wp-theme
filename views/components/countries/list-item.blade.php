@php
    $fields = get_fields($country);

    $countryThumbnailId = get_post_thumbnail_id($country);
    $countryTitle = get_the_title($country);
    $countryUrl = get_permalink($country);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $countrySummary = get_the_excerpt($country);
        $maxSummaryLength = 180;
        if (strlen($countrySummary) > $maxSummaryLength) {
            $countrySummary = substr($countrySummary, 0, $maxSummaryLength - 3) . '...';
        }

    $countryUsps = $fields['usps'] ?? '';
    $countryCategories = get_the_terms($country, 'country_categories');
@endphp

<div class="country-item group h-full">
    <div class="country-wrapper relative h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($countryThumbnailId)
            <div class="country-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $countryUrl }}" aria-label="Ga naar {{ $countryTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    <div class="country-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                        @foreach ($countryCategories as $category)
                            @php
                                $categoryColor = get_field('category_color', $category);
                                $categoryIcon = get_field('category_icon', $category);
                                $categoryImage = get_field('category_image', $category);
                            @endphp
                            <div style="background-color: {{ $categoryColor }}" class="country-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                @if($categoryImage)
                                    <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                                @endif
                                {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
                @include('components.image', [
                    'image_id' => $countryThumbnailId,
                    'size' => 'news-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $countryThumbnailIdTitle,
            ])
            </div>
        @endif
        <div class="country-data flex flex-col w-full grow mt-5">

            <a href="{{ $countryUrl }}" aria-label="Ga naar {{ $countryTitle }} pagina"
               class="country-title text-{{ $countryTitleColor }} font-bold text-lg group-hover:text-primary">{!! $countryTitle !!}</a>

            <div class="country-info">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($countrySummary))
                    <p class="country-summary text-{{ $countryTextColor }} mt-3 mb-2">{{ $countrySummary }}</p>
                @endif
                @if (!empty($visibleElements) && in_array('usp', $visibleElements) && !empty($countryUsps))
                        @foreach ($countryUsps as $usp)
                            <div class="flex items-center country-usp gap-x-2">
                                <i class="usp-icon fa-regular fa-check-circle text-secondary"></i>
                                <div class="text-{{ $countryTextColor }}">{{ $usp['usp'] }}</div>
                            </div>
                        @endforeach

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