@php
    $fields = get_fields($case);

    $caseQuote = $fields['case_quote'] ?? '';
    $caseText = $fields['case_text'] ?? '';
    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';

//    @dd($fields);

//    $activityThumbnailID = get_post_thumbnail_id($activity);
//    $activityTitle = get_the_title($activity);
    $caseUrl = get_permalink($case);
//
    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
//    $activitySummary = get_the_excerpt($activity);
//    $activityCategories = get_the_category($activity);
@endphp


<div class="klantcase-item w-full text-{{ $caseTextColor }}">


    <div class="relative flex h-full bg-cta-color rounded-{{ $borderRadius }}">
        <div class="absolute h-[50px] w-[1px] bg-quaternary left-[30px]">Case</div>

        <div class="w-3/5 bg-background-color p-12">
            <div class="w-full flex-col">
                @if ($caseLogo)
                    <div class="flex justify-end">
                        @include('components.image', [
                           'image_id' => $caseLogo,
                           'size' => 'full',
                           'object_fit' => 'contain',
                           'img_class' => 'w-[120px] h-auto object-contain',
                           'alt' => 'test'
                       ])
                    </div>
                @endif
                @if($caseQuote)
                    <div class="case-quote">
                        <p class="text-[36px] text-{{ $caseQuoteColor }}">{!! $caseQuote !!}</p>
                    </div>
                @endif

                @if ($caseText)
                    <div class="case-text">
                        @include('components.content', ['content' => apply_filters('the_content', $caseText), 'class' => 'mb-6'])
                    </div>
                @endif
                <div class="flex flex-col md:flex-row items-center gap-x-4 md:gap-x-6 gap-y-4">
                </div>
            </div>
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
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
        <div class="w-2/5">
            @if ($caseImage)
                @include('components.image', [
                   'image_id' => $caseImage,
                   'size' => 'full',
                   'object_fit' => 'cover',
                   'img_class' => 'w-full max-h-[400px] md:max-h-[600px] object-cover rounded-r-' . $borderRadius,
                   'alt' => 'test'
               ])
            @endif
        </div>
    </div>
</div>