@php
    $fields = get_fields($employee);

    $firstName = $fields['first_name'] ?? '';
    $lastName = $fields['last_name'] ?? '';
    $fullName = !empty($firstName) || !empty($lastName) ? $firstName . ' ' . $lastName : get_the_title($employee);
    $imageId = $fields['image'] ?? '';
    $hoverImageId = $fields['hover_image'] ?? '';


    $visibleElements = $block['data']['show_element'] ?? [];
    $function = $fields['function'] ?? '';
    $overviewText = $fields['overview_text'] ?? '';
    $mail = $fields['email'] ?? '';
    $phoneNumber = $fields['phone_number'] ?? '';
    $socials = $fields['socials'] ?? [];

    $showFullContactInfo = $block['data']['show_full_contact_info'] ?? false;
    $contactInfoDisplay = $block['data']['contact_info_display'] ?? '';

    $employeeCategories = get_the_terms($employee, 'employee_categories');

    $employeeUrl = get_permalink($employee);
    $pageLink = $block['data']['page_url'] ?? false;
@endphp

<div class="werknemer-item group h-full @if ($flyinEffect) employee-hidden @endif">
    <div class="werknemer-card relative h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        <div class="custom-height relative max-h-[360px] overflow-hidden w-full rounded-{{ $borderRadius }}">
            @if ($pageLink)
                <a href="{{ $employeeUrl }}" aria-label="Ga naar {{ $fullName }} pagina"
                   class="overlay left-0 top-0 absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
            @endif
            @if (!empty($visibleElements) && in_array('category', $visibleElements))
                <div class="employee-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                    @foreach ($employeeCategories as $category)
                        @php
                            $categoryColor = get_field('category_color', $category);
                            $categoryIcon = get_field('category_icon', $category);
                        @endphp
                        <div style="background-color: {{ $categoryColor }}" class="employee-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                            {!! $categoryIcon !!} {!! $category->name !!}
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="employee-image relative w-full h-full">
                @include('components.image', [
                     'image_id' => $imageId,
                     'size' => 'full',
                     'object_fit' => 'cover',
                     'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 @if($hoverImageId) group-hover:opacity-0 @else group-hover:scale-110 @endif rounded-' . $borderRadius,
                     'alt' => $fullName,
                ])
                @if (!empty($hoverImageId))
                    @include('components.image', [
                         'image_id' => $hoverImageId,
                         'size' => 'full',
                         'object_fit' => 'cover',
                         'img_class' => 'aspect-square w-full h-full object-cover object-center absolute top-0 left-0 transform ease-in-out duration-300 opacity-0 group-hover:opacity-100 rounded-' . $borderRadius,
                         'alt' => $fullName . ' hover',
                    ])
                @endif
            </div>
            @if (!empty($visibleElements) && in_array('contact_info', $visibleElements) && ($contactInfoDisplay == 'in_image'))
                <div class="contact-items absolute bottom-0 right-0 flex gap-x-2">
                    @if ($mail)
                        <a href="mailto:{{ $mail }}" aria-label="Mail naar {{ $mail }}" class="text-{{ $employeeTextColor }} hover:text-white ">
                            <div class="contact-icon-wrapper relative bg-primary w-10 h-10 flex justify-center items-center">
                                <div class="mail-icon">
                                    <i class="contact-text object-cover fas fa-envelope"></i>@if($showFullContactInfo) {{ $mail }} @endif
                                </div>
                            </div>
                        </a>
                    @endif
                    @if ($phoneNumber)
                        <a href="tel:{{ $phoneNumber }}" aria-label="Bel naar {{ $phoneNumber }}" class="text-{{ $employeeTextColor }} hover:text-white">
                            <div class="contact-icon-wrapper relative bg-primary w-10 h-10 flex justify-center items-center">
                                 <div class="phone-icon">
                                    <i class="contact-text object-cover fas fa-phone"></i>@if($showFullContactInfo) {{ $phoneNumber }} @endif
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            @endif
        </div>
        <div class="contact-info w-full mt-5 flex flex-col">
            @if (!empty($visibleElements) && in_array('name', $visibleElements))
                @if ($pageLink)
                    <a href="{{ $employeeUrl }}" aria-label="Ga naar {{ $fullName }} pagina"
                       class="w-fit name-text font-bold text-lg text-{{ $employeeTitleColor }}">{{ $firstName }} {{ $lastName }}</a>
                @else
                    <div class="name-text font-bold text-lg text-{{ $employeeTitleColor }}">{{ $firstName }} {{ $lastName }}</div>
                @endif
            @endif
            @if (!empty($visibleElements) && in_array('function', $visibleElements))
                <div class="function-text text-{{ $employeeTextColor }} font-medium">{{ $function }}</div>
            @endif
            @if (!empty($visibleElements) && in_array('socials', $visibleElements) && !empty($socials))
                <div class="social-items inline-flex gap-x-2">
                    @foreach ($socials as $social)
                        <a class="text-{{ $employeeTextColor }} text-2xl transform ease-in-out duration-300 hover:scale-110 hover:text-primary"
                           href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Ga naar social media pagina">
                            {!! $social['icon'] !!}
                        </a>
                    @endforeach
                </div>
            @endif
            @if (!empty($visibleElements) && in_array('contact_info', $visibleElements) && ($contactInfoDisplay == 'under_image'))
                <div class="contact-items relative w-fit">
                    @if ($mail)
                        <a href="mailto:{{ $mail }}" aria-label="Mail naar {{ $mail }}" class="mail-link text-{{ $employeeTextColor }} hover:text-primary">
                            <div class="contact-icon-wrapper relative">
                                <div class="mail-icon">
                                    <i class="contact-text w-4 object-cover fas fa-envelope mr-3"></i>@if($showFullContactInfo) {{ $mail }} @endif
                                    <div class="popup absolute left-1/2 transform -translate-x-1/2 bottom-full pb-1 hidden">
                                        <div class="popup-text bg-white border border-gray-300 p-2 rounded shadow-lg text-sm text-black w-fit whitespace-nowrap">{{ $mail }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                    @if ($phoneNumber)
                        <a href="tel:{{ $phoneNumber }}" aria-label="Bel naar {{ $phoneNumber }}" class="phone-link text-{{ $employeeTextColor }} hover:text-primary">
                            <div class="contact-icon-wrapper relative">
                                <div class="phone-icon">
                                    <i class="contact-text w-4 object-cover fas fa-phone mr-3"></i>@if($showFullContactInfo) {{ $phoneNumber }} @endif
                                    <div class="popup absolute left-1/2 transform -translate-x-1/2 bottom-full pb-1 hidden">
                                        <div class="popup-text bg-white border border-gray-300 p-2 rounded shadow-lg text-sm text-black w-fit whitespace-nowrap">{{ $phoneNumber }}</div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            @endif
            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements))
                <div class="overview-text text-{{ $employeeTextColor }} mt-3 mb-2">{!! $overviewText !!}</div>
            @endif
        </div>
    </div>
</div>