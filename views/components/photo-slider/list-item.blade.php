@php
    $imageCaption = $image['caption'] ?? '';
    $imageUrl = $image['url'] ?? '';
    $imageAlt = $image['alt'] ?? '';
    $imageId = $image['id'] ?? '';
    $imageLinkUrl = $image['link']['url'] ?? '';
    $imageLinkTarget = $image['link']['target'] ?? '';
    $imageLinkTitle = $image['link']['title'] ?? '';
@endphp

<div class="image-item group h-full w-full @if ($flyinEffect) image-hidden @endif">
    <div class="relative">
        @if ($imageId)
            @if ($imageLinkUrl)
                <div class="card-overlay absolute w-full h-full overflow-hidden rounded-{{ $borderRadius }}">
                    <a href="{{ $imageLinkUrl }}" target="{{ $imageLinkTarget }}" aria-label="Ga naar {{ $imageLinkTitle }} pagina" class="absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                </div>
            @endif
            @include('components.image', [
                'image_id' => $imageId,
                'size' => 'full',
                'object_fit' => $imageStyle,
                'img_class' => 'w-full h-full rounded-' . $borderRadius,
                'alt' => $imageAlt
            ])
        @endif
    </div>
    @if ($imageCaption)
        @if ($imageLinkUrl) <a href="{{ $imageLinkUrl }}" target="{{ $imageLinkTarget }}" aria-label="Ga naar {{ $imageLinkTitle }}">@endif
            <div class="caption-text text-lg text-left font-bold mt-2 text-{{ $captionColor }}">{!! $imageCaption !!}</div>
        @if ($imageLinkUrl) </a> @endif
    @endif
</div>