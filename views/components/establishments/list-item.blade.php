@php
    $fields = get_fields($establishment);

    $establishmentName = $fields['name'] ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];
//    $function = $fields['function'] ?? '';
//    $overviewText = $fields['overview_text'] ?? '';
//    $mail = $fields['email'] ?? '';
//    $phoneNumber = $fields['phone_number'] ?? '';
//    $socials = $fields['socials'] ?? [];
//
//    $showFullContactInfo = $block['data']['show_full_contact_info'] ?? false;
//    $contactInfoDisplay = $block['data']['contact_info_display'] ?? '';
@endphp

<div class="establishment-item group h-full">
    <div class="establishment-card h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">


{{--        <div class="custom-height max-h-[360px] overflow-hidden w-full rounded-{{ $borderRadius }}">--}}
{{--            @include('components.image', [--}}
{{--                 'image_id' => $imageID,--}}
{{--                 'size' => 'job-thumbnail',--}}
{{--                 'object_fit' => 'cover',--}}
{{--                 'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-' . $borderRadius ,--}}
{{--                 'alt' => $establishmentName,--}}
{{--            ])--}}
{{--        </div>--}}
{{--        <div class="contact-info w-full mt-5 flex flex-col">--}}
{{--            @if (!empty($visibleElements) && in_array('name', $visibleElements))--}}
{{--                <p class="name-text font-bold text-lg text-{{ $employeeTitleColor }}">{{ $firstName }} {{ $lastName }}</p>--}}
{{--            @endif--}}
{{--            @if (!empty($visibleElements) && in_array('function', $visibleElements))--}}
{{--                <p class="function-text text-{{ $employeeTextColor }} font-medium">{{ $function }}</p>--}}
{{--            @endif--}}
{{--            @if (!empty($visibleElements) && in_array('socials', $visibleElements) && !empty($socials))--}}
{{--                <div class="inline-flex gap-x-2">--}}
{{--                    @foreach ($socials as $social)--}}
{{--                        <a class="text-{{ $employeeTextColor }} text-2xl transform ease-in-out duration-300 hover:scale-110 hover:text-primary"--}}
{{--                           href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Ga naar social media pagina">--}}
{{--                            {!! $social['icon'] !!}--}}
{{--                        </a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            @endif--}}
{{--            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))--}}
{{--                <p class="overview-text text-{{ $employeeTextColor }} mt-3 mb-2">{{ $overviewText }}</p>--}}
{{--            @endif--}}
{{--        </div>--}}



    </div>
</div>