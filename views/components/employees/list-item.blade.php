@php
    $fields = get_fields($employee);

    $firstName = $fields['first_name'] ?? '';
    $lastName = $fields['last_name'] ?? '';
    $fullName = !empty($firstName) || !empty($lastName) ? $firstName . ' ' . $lastName : get_the_title($employee);
    $imageID = $fields['image'] ?? '';

    $visibleElements = $block['data']['show_element'] ?? [];
    $function = $fields['function'] ?? '';
    $overviewText = $fields['overview_text'] ?? '';
    $mail = $fields['email'] ?? '';
    $phoneNumber = $fields['phone_number'] ?? '';
    $socials = $fields['socials'] ?? [];

    $showFullContactInfo = $block['data']['show_full_contact_info'] ?? false;
@endphp

<div class="werknemer-item group h-full">
    <div class="werknemer-card h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out ">
        <div class="custom-height max-h-[360px] overflow-hidden w-full rounded-{{ $borderRadius }}">
            @include('components.image', [
                 'image_id' => $imageID,
                 'size' => 'job-thumbnail',
                 'object_fit' => 'cover',
                 'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-{{ $borderRadius }}',
                 'alt' => $fullName,
         ])
        </div>
        <div class="contact-info w-full mt-5 flex flex-col">
            @if (!empty($visibleElements) && in_array('name', $visibleElements))
                <p class="name-text font-bold text-lg text-{{ $employeeTitleColor }}">{{ $firstName }} {{ $lastName }}</p>
            @endif
            @if (!empty($visibleElements) && in_array('function', $visibleElements))
                <p class="function-text text-{{ $employeeTextColor }} font-medium">{{ $function }}</p>
            @endif
            @if (!empty($visibleElements) && in_array('socials', $visibleElements) && !empty($socials))
                <div class="inline-flex gap-x-2">
                    @foreach ($socials as $social)
                        <a class="text-{{ $employeeTextColor }} text-2xl transform ease-in-out duration-300 hover:scale-110 hover:text-primary"
                           href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Ga naar social media pagina">
                            {!! $social['icon'] !!}
                        </a>
                    @endforeach
                </div>
            @endif
            @if (!empty($visibleElements) && in_array('contact_info', $visibleElements))
                <div class="contact-items relative">
                    @if ($mail)
                        <div class="contact-icon-wrapper relative">
                            <div class="mail-icon">
                                <a href="mailto:{{ $mail }}" aria-label="Mail naar {{ $mail }}" class="text-{{ $employeeTextColor }} hover:text-primary ">
                                    <i class="contact-text w-4 object-cover fas fa-envelope mr-3"></i>@if($showFullContactInfo) {{ $mail }} @endif
                                </a>
                                <div class="popup absolute left-1/2 transform -translate-x-1/2 bottom-full pb-1 hidden">
                                    <div class=" bg-white border border-gray-300 p-2 rounded shadow-lg text-sm text-black w-fit whitespace-nowrap">{{ $mail }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($phoneNumber)
                        <div class="contact-icon-wrapper relative">
                            <div class="phone-icon">
                                <a href="tel:{{ $phoneNumber }}" aria-label="Bel naar {{ $phoneNumber }}" class="text-{{ $employeeTextColor }} hover:text-primary">
                                    <i class="contact-text w-4 object-cover fas fa-phone mr-3"></i>@if($showFullContactInfo) {{ $phoneNumber }} @endif
                                </a>
                                <div class="popup absolute left-1/2 transform -translate-x-1/2 bottom-full pb-1 hidden">
                                    <div class=" bg-white border border-gray-300 p-2 rounded shadow-lg text-sm text-black w-fit whitespace-nowrap">{{ $phoneNumber }}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))
                <p class="overview-text text-{{ $employeeTextColor }} mt-3 mb-2">{{ $overviewText }}</p>
            @endif
        </div>
    </div>
</div>