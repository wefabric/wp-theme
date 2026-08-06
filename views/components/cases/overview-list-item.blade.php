@php
    $fields = get_fields($case);

    $caseQuote = $fields['case_quote'] ?? '';
    $caseText = $fields['case_text'] ?? '';
    $caseTitle = get_the_title($case);
    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';
    $caseUrl = get_permalink($case);
    $caseExcerpt = get_the_excerpt($case);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $overviewCardStyle = $block['data']['overview_card_style'] ?? 'hover_overlay';
    $showCardButton = !empty($visibleElements) && in_array('button', $visibleElements) && $buttonCardText;
    $showCategory = !empty($visibleElements) && in_array('category', $visibleElements);
    $showOverviewText = !empty($visibleElements) && in_array('overview_text', $visibleElements);
    $caseCategories = $showCategory ? get_the_terms($case, 'case_categories') : [];

    // Afbeeldingen (klantcase afbeelding + extra afbeeldingen voor de swiper)
    $showImageSwiper = !empty($visibleElements) && in_array('image_slider', $visibleElements);
    $caseGalleryRows = get_field('case_images', $case) ?: [];
    $caseGalleryImageIds = array_values(array_filter(array_map(fn ($row) => $row['image'] ?? null, $caseGalleryRows)));
    $caseImageIds = $caseImage ? array_merge([$caseImage], $caseGalleryImageIds) : $caseGalleryImageIds;
    $caseImageIds = array_values(array_unique($caseImageIds));
    $hasMultipleCaseImages = $showImageSwiper && count($caseImageIds) > 1;
    $caseImageSwiperClass = 'case-image-swiper-' . $case . '-' . mt_rand(0, 999999);
@endphp

@if ($overviewCardStyle === 'always_visible')
    @php
        $caseSummaryText = strip_tags($caseExcerpt);
        $maxCardSummaryLength = 160;
        if (strlen($caseSummaryText) > $maxCardSummaryLength) {
            $caseSummaryText = substr($caseSummaryText, 0, $maxCardSummaryLength - 3) . '...';
        }
    @endphp

    <div class="klantcase-item group h-full w-full @if ($flyinEffect) klantencase-hidden @endif">
        <div class="card-static flex flex-col h-full w-full rounded-{{ $borderRadius }} overflow-hidden {{ $hoverEffectClass }} duration-300 ease-in-out">
            @if (!empty($caseImageIds))
                <div class="card-image relative w-full aspect-video overflow-hidden">
                    @if ($hasMultipleCaseImages)
                        <div class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out pointer-events-none"></div>
                    @else
                        <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina" class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out">
                            <span class="sr-only">Ga naar {{ $caseTitle }} pagina</span>
                        </a>
                    @endif
                    @if ($caseCategories && !is_bool($caseCategories))
                        <div class="case-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($caseCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="case-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    @if ($hasMultipleCaseImages)
                        <div class="case-image-swiper swiper {{ $caseImageSwiperClass }} h-full w-full">
                            <div class="swiper-wrapper h-full">
                                @foreach ($caseImageIds as $caseImageId)
                                    <div class="swiper-slide h-full">
                                        <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina" class="block h-full w-full overflow-hidden">
                                            @include('components.image', [
                                                'image_id' => $caseImageId,
                                                'size' => 'full',
                                                'object_fit' => 'cover',
                                                'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110',
                                                'alt' => $caseTitle,
                                            ])
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="case-image-nav">
                            <div role="button" tabindex="0" aria-label="Vorige foto" class="swiper-button-prev case-image-button-prev-{{ $caseImageSwiperClass }}"></div>
                            <div role="button" tabindex="0" aria-label="Volgende foto" class="swiper-button-next case-image-button-next-{{ $caseImageSwiperClass }}"></div>
                        </div>
                        <script>
                            window.addEventListener('DOMContentLoaded', () => {
                                new Swiper('.{{ $caseImageSwiperClass }}', {
                                    nested: true,
                                    preventClicks: true,
                                    preventClicksPropagation: true,
                                    navigation: {
                                        nextEl: '.case-image-button-next-{{ $caseImageSwiperClass }}',
                                        prevEl: '.case-image-button-prev-{{ $caseImageSwiperClass }}',
                                    },
                                });
                            });
                        </script>
                    @else
                        @include('components.image', [
                            'image_id' => $caseImageIds[0],
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110',
                            'alt' => $caseTitle,
                        ])
                    @endif
                </div>
            @endif

            <div class="card-content relative flex flex-col grow gap-y-3 p-6 bg-{{ $caseBackgroundColor }}">
                <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina" class="page-title text-{{ $caseTextColor }} h3 font-bold">
                    {!! $caseTitle !!}
                </a>

                @if ($showOverviewText && $caseSummaryText)
                    <p class="case-summary text-{{ $caseTextColor }} opacity-80 m-0">{{ $caseSummaryText }}</p>
                @endif

                @if ($showCardButton)
                    <div class="case-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $caseUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                           'icon' => $buttonCardIcon,
                       ])
                    </div>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="klantcase-item group h-full w-full @if ($flyinEffect) klantencase-hidden @endif">
        <div class="card-background p-6 xl:p-8 h-full mx-auto relative bg-{{ $caseBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-end text-center overflow-hidden rounded-{{ $borderRadius }} {{ $hoverEffectClass }} duration-300 ease-in-out"

             @if (!$hasMultipleCaseImages && $caseImage)
                 style="background-image: url('{{ wp_get_attachment_image_url($caseImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($caseImage) }}">
            @endif

            @if ($hasMultipleCaseImages)
                <div class="case-image-swiper swiper {{ $caseImageSwiperClass }} absolute inset-0 w-full h-full">
                    <div class="swiper-wrapper h-full">
                        @foreach ($caseImageIds as $caseImageId)
                            <div class="swiper-slide h-full">
                                @include('components.image', [
                                    'image_id' => $caseImageId,
                                    'size' => 'full',
                                    'object_fit' => 'cover',
                                    'img_class' => 'w-full h-full object-cover',
                                    'alt' => $caseTitle,
                                ])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="case-image-nav">
                    <div role="button" tabindex="0" aria-label="Vorige foto" class="swiper-button-prev case-image-button-prev-{{ $caseImageSwiperClass }}"></div>
                    <div role="button" tabindex="0" aria-label="Volgende foto" class="swiper-button-next case-image-button-next-{{ $caseImageSwiperClass }}"></div>
                </div>
                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                        new Swiper('.{{ $caseImageSwiperClass }}', {
                            navigation: {
                                nextEl: '.case-image-button-next-{{ $caseImageSwiperClass }}',
                                prevEl: '.case-image-button-prev-{{ $caseImageSwiperClass }}',
                            },
                        });
                    });
                </script>
            @endif

            @if ($caseCategories && !is_bool($caseCategories))
                <div class="case-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                    @foreach ($caseCategories as $category)
                        @php
                            $categoryColor = get_field('category_color', $category);
                            $categoryIcon = get_field('category_icon', $category);
                        @endphp
                        <div style="background-color: {{ $categoryColor }}" class="case-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                            {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                        </div>
                    @endforeach
                </div>
            @endif
            <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina" class="card-overlay absolute bottom-0 w-full opacity-80 transition-all duration-300 ease-in-out group-hover:h-full h-3/5 sm:h-1/2 lg:h-2/5 bg-primary rounded-b-{{ $borderRadius }} group-hover:rounded-t-{{ $borderRadius }}"></a>
            @if($showOverviewText && $caseExcerpt)
                <a href="{{ $caseUrl }} " aria-label="Ga naar {{ $caseTitle }} pagina" class="hidden lg:block text-{{ $caseTextColor }} absolute z-20 -translate-x-1/2 -translate-y-full left-1/2 top-1/2 opacity-0 group-hover:opacity-100 h5 transition-all duration-300 ease-in-out">{{ $caseExcerpt }}</a>
            @endif

            <a href="{{ $caseUrl }} " aria-label="Ga naar {{ $caseTitle }} pagina"
               class="text-{{ $caseTextColor }} page-title text-{{ $caseTextColor }} relative z-20 h3 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
                {!! $caseTitle !!}
            </a>

            @if ($showCardButton)
                <div class="page-button relative z-20 flex items-center">
                    @include('components.buttons.default', [
                       'text' => $buttonCardText,
                       'href' => $caseUrl,
                       'alt' => $buttonCardText,
                       'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                       'class' => 'rounded-lg',
                       'icon' => $buttonCardIcon,
                   ])
                </div>
            @endif
        </div>
    </div>
@endif
