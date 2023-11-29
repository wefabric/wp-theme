@php
    $fields = get_fields($logo);
    $logoImage = $fields['logo'] ?? '';
    $logoUrl = $fields['link'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $logoTitle = get_the_title($logo);
    $logoSummary = get_the_excerpt($logo);
@endphp

<div class="logo-item group h-full">
    <div class="h-full flex flex-col @if($logoUrl) group-hover:-translate-y-4 duration-300 ease-in-out @endif">
        <div class="overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            @if ($logoUrl)
                <a href="{{ $logoUrl }}" target="_blank"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-30 transition-opacity duration-300 ease-in-out"></a>
            @endif
            @if ($logoImage)
                @include('components.image', [
                    'image_id' => $logoImage,
                    'size' => 'full',
                    'object_fit' => 'contain',
                    'img_class' => 'w-full h-[200px] transition ease-in-out duration-300 ' . ($logoUrl ? 'group-hover:scale-105 ' : '') . 'rounded-' . $borderRadius,
                    'alt' => $logoTitle
                ])
            @endif
        </div>
        @if (!empty($visibleElements) && in_array('name', $visibleElements) && ($logoTitle))
            <p class="text-lg font-bold @if($logoUrl) group-hover:text-primary @endif">{{ $logoTitle }}</p>
        @endif
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($logoSummary))
            <p>{!! $logoSummary !!}</p>
        @endif
    </div>
</div>