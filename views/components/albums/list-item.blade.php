@php
    $fields = get_fields($album);

    $albumItems = $fields['album'] ?? [];
    $albumTitle = get_the_title($album) ?? '';
    $albumCover = get_post_thumbnail_id($album) ?? '';
    $albumUrl = get_permalink($album) ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];
@endphp


<div class="album-item group h-full">
    <div class="album-card h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        <div class="custom-height max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            <a href="{{ $albumUrl }}" aria-label="Ga naar {{ $albumTitle }} pagina"
               class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
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
                <p class="name-text font-bold text-lg text-{{ $albumTitleColor }}">{!! $albumTitle !!}</p>
            @endif
        </div>
    </div>
</div>





{{--<div class="flex flex-col gap-y-4">--}}

{{--    @if (!empty($visibleElements) && in_array('title', $visibleElements) && $programTitle)--}}
{{--        <h3 class="program-title mb-4">{!! $programTitle !!}</h3>--}}
{{--    @endif--}}

{{--    @foreach ($programItems as $programItem)--}}
{{--        <div class="program-item flex flex-col md:flex-row gap-y-2 gap-x-4 md:gap-x-8 w-full border-b pb-4">--}}
{{--            <div class="time">--}}
{{--                <div class="program-item-time font-bold text-{{ $programTitleColor }}">{!! $programItem['time'] !!}</div>--}}
{{--            </div>--}}
{{--            <div class="info">--}}
{{--                <div class="program-item-title font-bold text-{{ $programTitleColor }}">{!! $programItem['title'] !!}</div>--}}
{{--                <div class="program-item-text text-{{ $programTextColor }} ">--}}
{{--                    {!! $programItem['text'] !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endforeach--}}
{{--</div>--}}