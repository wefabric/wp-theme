@php
    $privateEventThumbnailId = get_post_thumbnail_id($privateEvent);
    $privateEventTitle = get_the_title($privateEvent);
    $privateEventSummary = get_the_excerpt($privateEvent);
    $privateEventUrl = get_permalink($privateEvent);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $privateEventCategories = get_the_terms($privateEvent, 'private_event_categories');
@endphp

<div class="private-event-item group h-full @if ($flyinEffect) private-event-hidden @endif">
    <div class="h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($privateEventThumbnailId)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $privateEventUrl }}" aria-label="Ga naar {{ $privateEventTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($privateEventCategories && !is_bool($privateEventCategories))
                        <div class="private-event-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($privateEventCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="private-event-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $privateEventThumbnailId,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $privateEventTitle,
                ])
            </div>
        @endif
        <div class="private-event-content flex flex-col w-full grow mt-5">

            <a href="{{ $privateEventUrl }}" aria-label="Ga naar {{ $privateEventTitle }} pagina" class="private-event-title-text font-bold text-{{ $eventTitleColor }} text-lg group-hover:text-primary">{!! $privateEventTitle !!}</a>

            <div class="private-event-data mt-4 text-{{ $eventTextColor }}">

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($privateEventSummary))
                    <p class="mt-3 mb-3">{{ $privateEventSummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="private-event-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $privateEventUrl,
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