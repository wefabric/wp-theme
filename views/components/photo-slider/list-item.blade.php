@php
    $imageCaption = $image['caption'] ?? '';
    $imageUrl = $image['url'] ?? '';
    $imageAlt = $image['alt'] ?? '';
    $imageId = $image['id'] ?? '';
    $imageLinkUrl = $image['link']['url'] ?? '';
    $imageLinkTarget = $image['link']['target'] ?? '';
    $imageLinkTitle = $image['link']['title'] ?? '';
@endphp

<div class="image-item group h-full w-full">
    @if ($imageId)
        @if ($imageLinkUrl)
            <div class="absolute w-full h-full overflow-hidden rounded-{{ $borderRadius }}">
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
    @if ($imageCaption)
        @if ($imageLinkUrl) <a href="{{ $imageLinkUrl }}" target="{{ $imageLinkTarget }}" aria-label="Ga naar {{ $imageLinkTitle }}">@endif
            <p class="text-lg text-left font-bold mt-2 text-{{ $captionColor }}">{!! $imageCaption !!}</p>
        @if ($imageLinkUrl) </a> @endif
    @endif
</div>