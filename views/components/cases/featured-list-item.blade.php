@php
    $fields = get_fields($case);
    $caseQuote = $fields['case_quote'] ?? '';

    $caseText = $fields['case_text'] ?? '';
    $mobileText= strip_tags($caseText);
        $maxSummaryLength = 250;
        if (strlen($mobileText) > $maxSummaryLength) {
            $mobileText = substr($mobileText, 0, $maxSummaryLength - 3) . '...';
        }

    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';
    $caseUrl = get_permalink($case);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $showCategory = !empty($visibleElements) && in_array('category', $visibleElements);
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

<div class="klantcase-item featured w-full h-full text-{{ $caseTextColor }} @if ($flyinEffect) klantencase-hidden @endif">
    <div class="klantcase-styling relative flex flex-col gap-x-12 md:flex-row h-full rounded-{{ $borderRadius }} overflow-hidden">
        <div class="case-line absolute left-[30px] h-full top-0">
            <div class="h-full py-12 flex flex-col items-center gap-4">
                <div class="vertical-text h6 text-quaternary-color">Case</div>
                <div class="quote-line hidden md:block h-full w-[1px] bg-quaternary-color"></div>
            </div>
        </div>

        <div class="flex w-full h-full md:w-3/5 order-2 md:order-1">
            <div class="case-data h-full flex flex-col flex-1 justify-start bg-{{ $caseBackgroundColor }} py-6 md:py-12 px-6 md:pl-24">
                <div class="flex-layout flex flex-col justify-between h-full">
                    @if ($caseLogo)
                        <div class="flex justify-center md:justify-end mb-4 logo">
                            @include('components.image', [
                                'image_id' => $caseLogo,
                                'size' => 'full',
                                'object_fit' => 'contain',
                                'img_class' => 'w-auto max-h-[120px] object-contain',
                                'alt' => 'Case logo'
                            ])
                        </div>
                    @endif
                    <div class="case-content">
                        @if($caseQuote)
                            <div class="case-quote">
                                <p class="quote-text mb-4 text-[24px] md:text-[36px] text-{{ $caseQuoteColor }}">{!! $caseQuote !!}</p>
                            </div>
                        @endif
                        @if ($caseText)
                            <div class="case-text">
                                <div class="block lg:hidden mb-6">
                                    {!! $mobileText !!}
                                </div>
                                <div class="hidden lg:block mb-6">
                                    {!! $caseText !!}
                                </div>
                            </div>
                        @endif
                        @if (!empty($visibleElements) && in_array('button', $visibleElements))
                            @if ($buttonCardText)
                                <div class="mt-4 z-10">
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="case-image relative w-full md:w-2/5 order-1 md:order-2">
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
                <div class="case-image-swiper swiper {{ $caseImageSwiperClass }} h-[200px] md:h-full w-full">
                    <div class="swiper-wrapper h-full">
                        @foreach ($caseImageIds as $caseImageId)
                            <div class="swiper-slide h-full">
                                @include('components.image', [
                                    'image_id' => $caseImageId,
                                    'size' => 'full',
                                    'object_fit' => 'cover',
                                    'img_class' => 'w-full h-full object-cover',
                                    'alt' => 'Case afbeelding',
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
            @elseif ($caseImage)
                @include('components.image', [
                    'image_id' => $caseImage,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'w-full h-[200px] md:h-full object-cover',
                    'alt' => 'Case afbeelding'
                ])
            @endif
        </div>
    </div>
</div>
