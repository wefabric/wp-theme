@php
    $fields = get_fields($logo);
    $logoImage = $fields['logo'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $logoTitle = get_the_title($logo);
    $logoSummary = get_the_excerpt($logo);

    $logoLinkType = $block['data']['logo_link'] ?? 'page_link';
        if ($logoLinkType === 'page_link') {
            $logoUrl = get_permalink($logo);
        } elseif ($logoLinkType === 'external_link') {
            $logoUrl = $fields['link'] ?? '';
        } elseif ($logoLinkType === 'no_link') {
             $logoUrl = '';
        } else {
            $logoUrl = '';
        }
@endphp

<div class="logo-item group rounded-{{ $borderRadius }}">
    <div class="h-full @if($logoUrl) group-hover:-translate-y-4 duration-300 ease-in-out @endif">
        <div class="overflow-hidden w-full relative p-4 md:p-6 bg-{{ $logoBackgroundColor }} rounded-{{ $borderRadius }}">
            @if ($logoUrl)
                <a href="{{ $logoUrl }}" @if($logoLinkType === 'external_link') target="_blank"
                   @endif class="absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-30 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>
            @endif
            @if ($logoImage)
                @include('components.image', [
                    'image_id' => $logoImage,
                    'size' => 'full',
                    'object_fit' => 'contain',
                    'img_class' => 'w-full h-[180px] transition ease-in-out duration-300' . ($logoUrl ? 'group-hover:scale-105 ' : '') . 'rounded-' . $borderRadius,
                    'alt' => $logoTitle
                ])
            @endif
        </div>
        @if (!empty($visibleElements) && in_array('name', $visibleElements) && ($logoTitle))
            @if ($logoUrl)
                <a href="{{ $logoUrl }}" @if($logoLinkType === 'external_link') target="_blank" @endif>@endif
                    <p class="mt-2 text-lg font-bold @if($logoUrl) group-hover:text-primary @endif">{{ $logoTitle }}</p>
                    @if ($logoUrl) </a>
            @endif
        @endif
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($logoSummary))
            <p>{!! $logoSummary !!}</p>
        @endif
    </div>
</div>