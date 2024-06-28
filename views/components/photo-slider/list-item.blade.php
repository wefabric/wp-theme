@php
    $imageCaption = $image['caption'] ?? '';
    $imageUrl = $image['url'] ?? '';
    $imageAlt = $image['alt'] ?? '';
    $imageID = $image['id'] ?? '';
    $imageLinkUrl = $image['link']['url'] ?? '';
    $imageLinkTarget = $image['link']['target'] ?? '';
    $imageLinkTitle = $image['link']['title'] ?? '';
@endphp

<div class="group h-full w-full">
    @if ($imageID)

        @if ($imageLinkUrl)
            <div class="absolute w-full h-full overflow-hidden rounded-{{ $borderRadius }}">
                <a href="{{ $imageLinkUrl }}" target="{{ $imageLinkTarget }}" aria-label="Ga naar {{ $imageLinkTitle }} pagina" class="absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
            </div>
        @endif

        @include('components.image', [
            'image_id' => $imageID,
            'size' => 'full',
            'object_fit' => 'cover',
            'img_class' => 'w-full h-[400px] h-[600px] object-cover rounded-' . $borderRadius,
            'alt' => $imageAlt
        ])

    @endif

    @if ($imageCaption)
        @if ($imageLinkUrl) <a href="{{ $imageLinkUrl }}" target="{{ $imageLinkTarget }}" aria-label="Ga naar {{ $imageLinkTitle }}"> @endif
            <p class="text-lg font-bold mt-2">{{ $imageCaption }}</p>
        @if ($imageLinkUrl) </a> @endif
    @endif
</div>