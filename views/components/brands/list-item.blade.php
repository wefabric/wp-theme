@php
    $fields = get_fields($brand);
    $logoImage = $fields['logo'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $brandTitle = get_the_title($brand);
    $brandSummary = get_the_excerpt($brand);

    $brandLinkType = $block['data']['brand_link'] ?? 'page_link';
        if ($brandLinkType === 'page_link') {
            $brandUrl = get_permalink($brand);
        } elseif ($brandLinkType === 'external_link') {
            $brandUrl = $fields['link'] ?? '';
        } elseif ($brandLinkType === 'no_link') {
             $brandUrl = '';
        } else {
            $brandUrl = '';
        }
@endphp

<div class="brand-item group rounded-{{ $borderRadius }}">
    <div class="h-full @if($brandUrl) group-hover:-translate-y-4 duration-300 ease-in-out @endif">
        <div class="background overflow-hidden w-full relative p-4 md:p-6 bg-{{ $brandBackgroundColor }} rounded-{{ $borderRadius }}">
            @if ($brandUrl)
                <a href="{{ $brandUrl }}" @if($brandLinkType === 'external_link') aria-label="Ga naar {{ $brandTitle }}" target="_blank"
                   @endif class="overlay absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-30 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>
            @endif
            @if ($logoImage)
                @include('components.image', [
                    'image_id' => $logoImage,
                    'size' => 'full',
                    'object_fit' => 'contain',
                    'img_class' => 'w-full h-[180px] transition ease-in-out duration-300' . ($brandUrl ? 'group-hover:scale-105 ' : ''),
                    'alt' => $brandTitle
                ])
            @endif
        </div>
        @if (!empty($visibleElements) && in_array('name', $visibleElements) && ($brandTitle))
            @if ($brandUrl)
                <a href="{{ $brandUrl }}" @if($brandLinkType === 'external_link') target="_blank" @endif aria-label="Ga naar {{ $brandTitle }}">@endif
                    <p class="mt-2 text-lg font-bold @if($brandUrl) group-hover:text-primary @endif">{!! $brandTitle !!}</p>
                    @if ($brandUrl) </a>
            @endif
        @endif
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($brandSummary))
            <p>{!! $brandSummary !!}</p>
        @endif
    </div>
</div>