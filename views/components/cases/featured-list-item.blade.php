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
@endphp

<div class="klantcase-item featured w-full h-full text-{{ $caseTextColor }}">
    <div class="relative flex flex-col md:flex-row h-full rounded-{{ $borderRadius }} overflow-hidden">
        <div class="absolute left-[30px] h-full top-0">
            <div class="h-full py-12 flex flex-col items-center gap-4">
                <div class="h6 text-quaternary-color vertical-text">Case</div>
                <div class="hidden md:block h-full w-[1px] bg-quaternary-color"></div>
            </div>
        </div>

        <div class="flex w-full h-full md:w-3/5 order-2 md:order-1">
            <div class="h-full flex flex-col flex-1 justify-start bg-{{ $caseBackgroundColor }} py-6 md:py-12 pl-6 md:pl-24 pr-6 md:pr-12">
                <div class="flex flex-col justify-between h-full">
                    <div class="flex justify-center md:justify-end mb-4 logo">
                        @if ($caseLogo)
                            @include('components.image', [
                                'image_id' => $caseLogo,
                                'size' => 'full',
                                'object_fit' => 'contain',
                                'img_class' => 'w-auto max-h-[120px] object-contain',
                                'alt' => 'test'
                            ])
                        @endif
                    </div>
                    <div class="case-content">
                        @if($caseQuote)
                            <div class="case-quote">
                                <p class="quote-text mb-4 text-[24px] md:text-[36px] text-{{ $caseQuoteColor }}">{!! $caseQuote !!}</p>
                            </div>
                        @endif
                        @if ($caseText)
                            <div class="case-text">
                                <div class="block lg:hidden">
                                    @include('components.content', ['content' => apply_filters('the_content', $mobileText), 'class' => 'mb-6'])
                                </div>
                                <div class="hidden lg:block">
                                    @include('components.content', ['content' => apply_filters('the_content', $caseText), 'class' => 'mb-6'])
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
                                    ])
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="case-image w-full md:w-2/5 order-1 md:order-2">
            @if ($caseImage)
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
