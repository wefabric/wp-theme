@php
    $fields = get_fields($logo);
    $logoImage = $fields['logo'] ?? '';
    $logoUrl = $fields['link'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $logoTitle = get_the_title($logo);
    $logoSummary = get_the_excerpt($logo);
@endphp

<div class="logo-item">
    @if ($logoUrl)<a href="{{ $logoUrl }}" target="_blank" class="group">@endif
            @if ($logoImage)
                @include('components.image', [
                    'image_id' => $logoImage,
                    'size' => 'full',
                    'object_fit' => 'contain',
                    'img_class' => 'w-full h-[200px] transition ease-in-out duration-300 group-hover:scale-105 rounded-' . $borderRadius,
                    'alt' => $logoTitle
                ])
            @endif
            @if (!empty($visibleElements) && in_array('name', $visibleElements) && ($logoTitle))
                <p class="group-hover:text-primary text-lg font-bold">{{ $logoTitle }}</p>
            @endif
            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($logoSummary))
                <p>{!! $logoSummary !!}</p>
            @endif
    @if ($logoUrl)</a>@endif
</div>