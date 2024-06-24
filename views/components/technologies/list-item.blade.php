@php
    $fields = get_fields($technology);
    $technologyThumbnailID = get_post_thumbnail_id($technology);
    $technologyTitle = get_the_title($technology);
    $technologyUrl = get_permalink($technology);


    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $technologySummary = get_the_excerpt($technology);
    $overviewText = $fields['overview_text'] ?? '';
@endphp

<div class="technology-item group h-full">
    <div class="technology-card h-full group-hover:-translate-y-4 duration-300 ease-in-out @if( $technologyLayout == 'horizontal') flex flex-col md:flex-row gap-x-12 justify-start md:items-center text-left @elseif( $uspLayout == 'vertical') flex flex-col gap-y-4 text-center @endif">

        @if ($technologyThumbnailID)
            <div class="@if( $technologyLayout == 'horizontal') max-h-[300px] max-w-[300px] @elseif( $uspLayout == 'vertical') max-h-[360px] @endif overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $technologyUrl }}" aria-label="Ga naar {{ $technologyTitle }}"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>

                @include('components.image', [
                    'image_id' => $technologyThumbnailID,
                    'size' => 'job-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                    'alt' => $technologyTitle,
                ])
            </div>
        @endif

        <div class="w-full mt-5 flex flex-col">
            @if (!empty($visibleElements) && in_array('title', $visibleElements))
                <a href="{{ $technologyUrl }}" aria-label="Ga naar {{ $technologyTitle }}"
                   class="font-bold text-{{ $tecnologyTitleColor }} text-lg group-hover:text-primary">{{ $technologyTitle }}</a>
            @endif

            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))
                <p class="overview-text text-{{ $technologyTextColor }} mt-3 mb-2">{{ $technologySummary }}</p>
            @endif

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                     <div class="mt-auto pt-8 z-10">
                         @include('components.buttons.default', [
                            'text' => $buttonCardText,
                            'href' => $technologyUrl,
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