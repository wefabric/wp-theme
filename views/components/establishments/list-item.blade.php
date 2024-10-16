@php
    $fields = get_fields($establishment);

    $establishmentName = $fields['name'] ?? '';
    $establishmentImage = get_post_thumbnail_id($establishment);

    $visibleElements = $block['data']['show_element'] ?? [];
    $establishmentStreet = $fields['street'] ?? '';
    $establishmentHouseNumber = $fields['house_number'] ?? '';
    $establishmentHouseNumberAddition = $fields['house_number_addition'] ?? '';
    $establishmentZipCode = $fields['postcode'] ?? '';
    $establishmentCity = $fields['city'] ?? '';
    $establishmentAddress = $establishmentStreet . ' ' . $establishmentHouseNumber . $establishmentHouseNumberAddition . ', ' . $establishmentZipCode . ' ' . $establishmentCity;

// todo: add contact info of establishment
@endphp

<div class="establishment-item group h-full">

{{-- todo: add check if link for hover effect--}}
    <div class="establishment-card h-full flex flex-col items-center @if ($link) group-hover:-translate-y-4 duration-300 ease-in-out @endif">

        <div class="custom-height max-h-[360px] overflow-hidden w-full rounded-{{ $borderRadius }}">
            @include('components.image', [
                 'image_id' => $establishmentImage,
                 'size' => 'job-thumbnail',
                 'object_fit' => 'cover',
                 'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-' . $borderRadius ,
                 'alt' => $establishmentName,
            ])
        </div>

        <div class="establishment-info w-full mt-5 flex flex-col">
            @if (!empty($visibleElements) && in_array('name', $visibleElements))
                <p class="establishment-text font-bold text-lg text-{{ $establishmentTitleColor }}">{!! $establishmentName !!}</p>
            @endif

            @if (!empty($visibleElements) && in_array('address', $visibleElements))
                <p class="establishment-address flex items-baseline leading-[1.5] text-{{ $establishmentTextColor }}">
                    <i class="w-4 object-cover fas fa-map-marker-alt mr-3"></i>
                    {!! $establishmentStreet . ' ' . $establishmentHouseNumber . $establishmentHouseNumberAddition !!}
                    <br>
                    {!! $establishmentZipCode . ' ' . $establishmentCity !!}
                </p>
            @endif

            {{-- todo: add contact information --}}

        </div>
    </div>
</div>