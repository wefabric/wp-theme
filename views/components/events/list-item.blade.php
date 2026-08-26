@php
    $eventThumbnailId = get_post_thumbnail_id($event);
    $eventTitle = get_the_title($event);
    $eventSummary = get_the_excerpt($event);
    $eventUrl = get_permalink($event);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $eventCategories = get_the_terms($event, 'event_categories');

    // Er is (nog) geen datum- of locatieveld op dit post type. Zonder een
    // echte startDate is Event-schema ongeldig, en een verzonnen datum/locatie
    // levert misleidende markup op — dus alleen toevoegen als het veld er is.
    $eventFields = get_fields($event);
    $eventStartDate = $eventFields['event_date'] ?? $eventFields['start_date'] ?? $eventFields['date'] ?? '';
    $eventLocation = $eventFields['location'] ?? $eventFields['locatie'] ?? '';

    if ($eventStartDate && is_singular('evenementen') && get_the_ID() === $event) {
        $eventSchema = [
            '@type' => 'Event',
            'name' => strip_tags($eventTitle),
            'description' => strip_tags($eventSummary ?: $eventTitle),
            'url' => $eventUrl,
            'startDate' => date('c', strtotime($eventStartDate)),
            'eventStatus' => 'https://schema.org/EventScheduled',
            'organizer' => [
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'url' => home_url(),
            ],
        ];

        if ($eventLocation) {
            $eventSchema['location'] = [
                '@type' => 'Place',
                'name' => $eventLocation,
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $eventLocation,
                ],
            ];
        }

        if ($eventThumbnailId) {
            $eventSchema['image'] = str_replace('//content', '/content', wp_get_attachment_image_url($eventThumbnailId, 'full'));
        }

        \Wefabric\WPSupport\Schema\JsonLd::addSchema('event_' . $event, $eventSchema);
    }
@endphp

<div class="event-item group h-full @if ($flyinEffect) event-hidden @endif">
    <div class="h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        @if ($eventThumbnailId)
            <div class="image-container max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $eventUrl }}" aria-label="Ga naar {{ $eventTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out">
                    <span class="sr-only">Ga naar {{ $eventTitle }} pagina</span>
                </a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($eventCategories && !is_bool($eventCategories))
                        <div class="event-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($eventCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                    $categoryImage = get_field('category_image', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="event-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    @if($categoryImage)
                                        <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                                    @endif
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $eventThumbnailId,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $eventTitle,
                ])
            </div>
        @endif
        <div class="event-content flex flex-col w-full grow mt-5">

            <a href="{{ $eventUrl }}" aria-label="Ga naar {{ $eventTitle }} pagina" class="event-title-text font-bold text-{{ $eventTitleColor }} text-lg group-hover:text-primary">{!! $eventTitle !!}</a>

            <div class="event-data mt-4 text-{{ $eventTextColor }}">

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($eventSummary))
                    <p class="mt-3 mb-3">{{ $eventSummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="event-button mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $eventUrl,
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