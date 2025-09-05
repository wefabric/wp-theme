@php
    $fields = get_fields($album);

    $albumItems = $fields['album'] ?? [];
    $albumTitle = get_the_title($album) ?? '';
    $albumCover = get_post_thumbnail_id($album) ?? '';
    $albumUrl = get_permalink($album) ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

<div class="album-item group h-full @if ($flyinEffect) album-hidden @endif">
    <div class="album-card h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        <div class="custom-height max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            <a href="{{ $albumUrl }}" aria-label="Ga naar {{ $albumTitle }} pagina"
               class="card-overlay absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out">
                <span class="sr-only">Ga naar {{ $albumTitle }} pagina</span>
            </a>
            @include('components.image', [
                 'image_id' => $albumCover,
                 'size' => 'job-thumbnail',
                 'object_fit' => 'cover',
                 'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-' . $borderRadius ,
                 'alt' => $albumTitle,
            ])
        </div>
        <div class="album-info w-full mt-5 flex flex-col">
            @if (!empty($visibleElements) && in_array('title', $visibleElements))
                <a href="{{ $albumUrl }}" aria-label="Ga naar {{ $albumTitle }} pagina" class="album-title w-fit font-bold text-lg text-{{ $albumTitleColor }}">{!! $albumTitle !!}</a>
            @endif
        </div>
    </div>
</div>