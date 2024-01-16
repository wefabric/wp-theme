@php
    $organisationImage = get_post_thumbnail_id($organisation);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $organisationTitle = get_the_title($organisation);
    $organisationSummary = get_the_excerpt($organisation);
@endphp

<div class="organisation-item group rounded-{{ $borderRadius }}">
    <div class="h-full">
        <div class="overflow-hidden w-full relative p-4 md:p-6 bg-{{ $organisationBackgroundColor }} rounded-{{ $borderRadius }}">
            @if ($organisationImage)
                @include('components.image', [
                    'image_id' => $organisationImage,
                    'size' => 'full',
                    'object_fit' => 'contain',
                    'img_class' => 'w-full h-[180px] transition ease-in-out duration-300' . 'rounded-' . $borderRadius,
                    'alt' => $organisationTitle
                ])
            @endif
        </div>
        @if (!empty($visibleElements) && in_array('name', $visibleElements) && ($organisationTitle))
            <p class="mt-2 text-lg font-bold text-{{ $organisationTitleColor }}">{!! $organisationTitle !!}</p>
        @endif
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($organisationSummary))
            <p class="text-{{ $organisationTextColor }} ">{!! $organisationSummary !!}</p>
        @endif
    </div>
</div>