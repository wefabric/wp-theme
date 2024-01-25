@php
  $fields = get_fields($organisation);
  $organisationImage = get_post_thumbnail_id($organisation);

  // Weergave
  $visibleElements = $block['data']['show_element'] ?? [];
  $organisationTitle = get_the_title($organisation);
  $organisationSummary = get_the_excerpt($organisation);
  $organisationUrl = $fields['link'] ?? '';
@endphp

<div class="organisation-item group rounded-{{ $borderRadius }}">
    <div class="h-full @if($organisationUrl) group-hover:-translate-y-4 duration-300 ease-in-out @endif"">
        <div class="overflow-hidden w-full relative p-4 md:p-6 bg-{{ $organisationBackgroundColor }} rounded-{{ $borderRadius }}">
            @if ($organisationUrl)
                <a href="{{ $organisationUrl }}" target="_blank" aria-label="Ga naar {{ $organisationTitle }}"
                 class="absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-30 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>
            @endif
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
            @if ($organisationUrl)
                <a href="{{ $organisationUrl }}" target="_blank" aria-label="Ga naar {{ $organisationTitle }}">
            @endif
            <p class="mt-2 text-lg font-bold text-{{ $organisationTitleColor }} @if($organisationUrl) group-hover:text-primary @endif">{!! $organisationTitle !!}</p>
            @if ($organisationUrl)</a>@endif
        @endif
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && ($organisationSummary))
            <p class="text-{{ $organisationTextColor }} ">{!! $organisationSummary !!}</p>
        @endif
    </div>
</div>