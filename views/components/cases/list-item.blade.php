@php
    $fields = get_fields($case);

    $caseQuote = $fields['case_quote'] ?? '';
    $caseText = $fields['case_text'] ?? '';
    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';
    $caseUrl = get_permalink($case);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

<div class="klantcase-item w-full text-{{ $caseTextColor }}">
    <div class="relative flex h-full rounded-{{ $borderRadius }}">
        <div class="absolute left-[30px] h-full top-0">
            <div class="h-full py-12 flex flex-col items-center gap-4">
                <div class="h6 text-quaternary-color vertical-text">Case</div>
                <div class="h-full w-[1px] bg-quaternary-color"></div>
            </div>
        </div>

        <div class="flex w-3/5">
            <div class="h-full flex flex-col flex-1 justify-start bg-{{ $caseBackgroundColor }} py-12 pl-24 pr-12 rounded-l-{{ $borderRadius }}">
                <div class="flex flex-col justify-between h-full">
                    <div class="flex justify-end logo">
                        @if ($caseLogo)
                            @include('components.image', [
                                'image_id' => $caseLogo,
                                'size' => 'full',
                                'object_fit' => 'contain',
                                'img_class' => 'w-[120px] h-auto object-contain',
                                'alt' => 'test'
                            ])
                        @endif
                    </div>
                    <div class="case-content">
                        @if($caseQuote)
                            <div class="case-quote">
                                <p class="quote-style mb-4 text-[36px] text-{{ $caseQuoteColor }}">{!! $caseQuote !!}</p>
                            </div>
                        @endif
                        @if ($caseText)
                            <div class="case-text">
                                @include('components.content', ['content' => apply_filters('the_content', $caseText), 'class' => 'mb-6'])
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
        <div class="w-2/5">
            @if ($caseImage)
                @include('components.image', [
                    'image_id' => $caseImage,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'w-full h-full object-cover rounded-r-' . $borderRadius,
                    'alt' => 'Case afbeelding'
                ])
            @endif
        </div>
    </div>
</div>
