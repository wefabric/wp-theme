@php
    $dienstThumbnailId = get_post_thumbnail_id($dienst);
    $dienstTitle = get_the_title($dienst);
    $dienstSummary = get_the_excerpt($dienst);
    $dienstUrl = get_permalink($dienst);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $dienstCategories = get_the_terms($dienst, 'dienst_categories');
@endphp

<div class="dienst-item group h-full @if ($flyinEffect) dienst-hidden @endif">
    <div class="h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($dienstThumbnailId)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $dienstUrl }}" aria-label="Ga naar {{ $dienstTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($dienstCategories && !is_bool($dienstCategories))
                        <div class="dienst-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($dienstCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="dienst-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $dienstThumbnailId,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $dienstTitle,
                ])
            </div>
        @endif
        <div class="dienst-content flex flex-col w-full grow mt-5">

            <a href="{{ $dienstUrl }}" aria-label="Ga naar {{ $dienstTitle }} pagina" class="dienst-title-text font-bold text-{{ $dienstTitleColor }} text-lg group-hover:text-primary">{!! $dienstTitle !!}</a>

            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($dienstSummary))
                <div class="dienst-data mt-4 text-{{ $dienstTextColor }}">
                    <div class="mt-3 mb-3">{{ $dienstSummary }}</div>
                </div>
            @endif

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="dienst-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $dienstUrl,
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