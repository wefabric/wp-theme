@php
    $fields = get_fields($program);
    $programItems = $fields['program'] ?? [];
    $programTitle = get_the_title($program) ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];

    $hasImage = collect($programItems)->contains(function ($item) {
        return !empty($item['image']);
    });
@endphp

<div class="flex flex-col gap-y-4">

    @if (!empty($visibleElements) && in_array('title', $visibleElements) && $programTitle)
        <h3 class="program-title mb-4">{!! $programTitle !!}</h3>
    @endif

    @foreach ($programItems as $programItem)
        <div class="program-item flex flex-col md:flex-row gap-y-2 gap-x-4 md:gap-x-8 w-full border-b pb-4">
            @if ($hasImage)
                <div class="image md:w-52 shrink-0">
                    @if (!empty($programItem['image']))
                        @include('components.image', [
                           'image_id' => $programItem['image'],
                           'size' => 'full',
                           'object_fit' => 'cover',
                           'img_class' => 'w-full h-auto object-cover',
                           'alt' => $programItem['title']
                        ])
                    @endif
                </div>
            @endif
            <div class="time md:w-32 shrink-0">
                <div class="program-item-time font-bold text-{{ $programTitleColor }}">{!! $programItem['time'] !!}</div>
            </div>
            <div class="info">
                <div class="program-item-title font-bold text-{{ $programTitleColor }}">{!! $programItem['title'] !!}</div>
                <div class="program-item-text text-{{ $programTextColor }} ">
                    {!! $programItem['text'] !!}
                </div>
            </div>
        </div>
    @endforeach

</div>