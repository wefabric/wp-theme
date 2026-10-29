@php
    $establishmentModel = new \Wefabric\WPEstablishments\Establishment($establishment);

    $establishmentName = $establishmentModel->name ?? '';
    $establishmentImage = get_post_thumbnail_id($establishment);

    $visibleElements = $block['data']['show_element'] ?? [];

    $establishmentAddressDto = $establishmentModel->getAddress();
    $establishmentStreet = $establishmentAddressDto->street ?? '';
    $establishmentHouseNumber = $establishmentAddressDto->housenumber ?? '';
    $establishmentHouseNumberAddition = $establishmentAddressDto->housenumber_addition ?? '';
    $establishmentZipCode = $establishmentAddressDto->postcode ?? '';
    $establishmentCity = $establishmentAddressDto->city ?? '';
    $establishmentAddress = $establishmentStreet . ' ' . $establishmentHouseNumber . $establishmentHouseNumberAddition . ', ' . $establishmentZipCode . ' ' . $establishmentCity;

    $establishmentOverviewText = $establishmentModel->post->post_excerpt ?? '';
    $establishmentPhone = $establishmentModel->getContactPhone();
    $establishmentEmail = $establishmentModel->getEmailAddress();
    $establishmentWhatsapp = $establishmentModel->whatsapp_number ?? '';
    $establishmentKvkNumber = $establishmentModel->coc_number ?? '';
    $establishmentVatNumber = $establishmentModel->vat_number ?? '';

    $establishmentOpeningHours = get_field('opening_hours', $establishment) ?: [];
    $establishmentUrl = get_permalink($establishment);

    // Knop op de kaart (zelfde opties als andere blokken)
    $cardButtonText = $block['data']['card_button_button_text'] ?? '' ?: 'Meer informatie';
    $cardButtonColor = $block['data']['card_button_button_color'] ?? '' ?: 'primary-color';
    $cardButtonStyle = $block['data']['card_button_button_style'] ?? '' ?: 'outline';
    $cardButtonIcon = $block['data']['card_button_button_icon'] ?? '';
    if (!empty($cardButtonIcon)) {
        $cardButtonIconData = json_decode($cardButtonIcon, true);
        if (isset($cardButtonIconData['id'], $cardButtonIconData['style'])) {
            $cardButtonIcon = 'fa-' . $cardButtonIconData['style'] . ' fa-' . $cardButtonIconData['id'];
        }
    }

    // Uitgelichte werknemers
    $featuredEmployees = get_field('featured_employees', $establishment) ?: [];
    $featuredEmployees = array_values(array_filter(array_map(fn ($employee) => is_object($employee) ? $employee->ID : (int) $employee, (array) $featuredEmployees)));
    $employeeSliderId = 'establishmentEmployees-' . $establishment . '-' . rand(0, 100000);
@endphp

<div class="establishment-item group h-full @if ($flyinEffect) establishment-hidden @endif">
    <div class="establishment-card h-full flex flex-col items-center {{ $hoverEffectClass }} duration-300 ease-in-out">
        <div class="image-container custom-height max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
            @include('components.image', [
                 'image_id' => $establishmentImage,
                 'size' => 'job-thumbnail',
                 'object_fit' => 'cover',
                 'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-' . $borderRadius ,
                 'alt' => $establishmentName,
            ])
        </div>

        <div class="establishment-info flex flex-col w-full grow mt-5">
            @if (!empty($visibleElements) && in_array('name', $visibleElements))
                <p class="establishment-name font-bold text-lg text-{{ $establishmentTitleColor }}">{!! $establishmentName !!}</p>
            @endif

            <div class="establishment-data mt-4 text-{{ $establishmentTextColor }}">
                @if (!empty($visibleElements) && in_array('address', $visibleElements))
                    <div class="establishment-address flex items-baseline leading-[1.5]">

                        {!! $establishmentStreet . ' ' . $establishmentHouseNumber . $establishmentHouseNumberAddition !!}
                        <br>
                        {!! $establishmentZipCode . ' ' . $establishmentCity !!}
                    </div>
                @endif

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && $establishmentOverviewText)
                    <div class="establishment-overview mt-2">{!! nl2br(e($establishmentOverviewText)) !!}</div>
                @endif

                @if (!empty($visibleElements) && in_array('kvk_number', $visibleElements) && $establishmentKvkNumber)
                    <div class="establishment-kvk mt-2">KvK: {{ $establishmentKvkNumber }}</div>
                @endif

                @if (!empty($visibleElements) && in_array('vat_number', $visibleElements) && $establishmentVatNumber)
                    <div class="establishment-vat">BTW nummer: {{ $establishmentVatNumber }}</div>
                @endif

                @if (!empty($visibleElements) &&
                    (
                        (in_array('phone', $visibleElements) && $establishmentPhone) ||
                        (in_array('email', $visibleElements) && $establishmentEmail) ||
                        (in_array('whatsapp', $visibleElements) && $establishmentWhatsapp) ||
                        in_array('route', $visibleElements)
                    )
                )
                    <div class="establishment-contact flex flex-col gap-y-2 mt-2">
                        @if (in_array('phone', $visibleElements) && $establishmentPhone)
                            <a class="phone-link group/link flex items-center gap-2 w-fit"
                               href="{{ $establishmentPhone->uri() }}"
                               title="Telefoonnummer">
                                <i class="fa-solid fa-phone text-primary"></i>
                                <span class="align-middle group-hover/link:text-primary group-hover/link:underline">{{ get_bloginfo('language') === 'nl-NL' ? $establishmentPhone->national() : $establishmentPhone->international() }}</span>
                            </a>
                        @endif

                        @if (in_array('email', $visibleElements) && $establishmentEmail)
                            <a class="email-link group/link flex items-center gap-2 w-fit"
                               href="mailto:{{ $establishmentEmail }}"
                               title="E-mailadres">
                                <i class="fa-solid fa-envelope text-primary"></i>
                                <span class="align-middle group-hover/link:text-primary group-hover/link:underline">{{ $establishmentEmail }}</span>
                            </a>
                        @endif

                        @if (in_array('whatsapp', $visibleElements) && $establishmentWhatsapp)
                            <a class="whatsapp-link group/link flex items-center gap-2 w-fit"
                               href="https://wa.me/{{ preg_replace('/\D+/', '', $establishmentWhatsapp) }}"
                               target="_blank" rel="noopener"
                               title="Whatsapp">
                                <i class="fa-brands fa-whatsapp text-primary"></i>
                                <span class="align-middle group-hover/link:text-primary group-hover/link:underline">{{ $establishmentWhatsapp }}</span>
                            </a>
                        @endif

                        @if (in_array('route', $visibleElements))
                            <a class="route-link group/link flex items-center gap-2 w-fit"
                               href="{{ $establishmentAddressDto->getGoogleMapsUrl() }}"
                               target="_blank" rel="noopener"
                               title="Routebeschrijving">
                                <i class="fa-solid fa-route text-primary"></i>
                                <span class="align-middle group-hover/link:text-primary group-hover/link:underline">Route</span>
                            </a>
                        @endif
                    </div>
                @endif

                @if (in_array('opening_hours', (array) $visibleElements) && !empty($establishmentOpeningHours))
                    <div class="establishment-opening-hours mt-4">
                        <p class="establishment-opening-hours-title">Openingstijden</p>
                        @foreach ($establishmentOpeningHours as $day)
                            <div class="establishment-opening-hours-row flex flex-wrap gap-x-2">
                                <span class="day">{{ $day['day'] ?? '' }}:</span>
                                @if (!empty($day['closed']))
                                    <span class="hours">gesloten</span>
                                @else
                                    <span class="hours">
                                        {{ $day['opening_hour'] ?? '' }} – {{ $day['closing_hour'] ?? '' }} uur
                                        @if (!empty($day['opening_hour_2']) && !empty($day['closing_hour_2']))
                                            &amp; {{ $day['opening_hour_2'] }} – {{ $day['closing_hour_2'] }} uur
                                        @endif
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            @if (in_array('more_info', (array) $visibleElements) && $establishmentUrl)
                <div class="establishment-more-info buttons mt-auto pt-6">
                    @include('components.buttons.default', [
                        'text' => $cardButtonText,
                        'href' => $establishmentUrl,
                        'alt' => $cardButtonText . ' - ' . strip_tags($establishmentName),
                        'colors' => 'btn-' . $cardButtonColor . ' btn-' . $cardButtonStyle,
                        'class' => 'rounded-lg',
                        'icon' => $cardButtonIcon,
                    ])
                </div>
            @endif
        </div>

        @if (in_array('featured_employees', (array) $visibleElements) && !empty($featuredEmployees))
            @php $employeeCount = count($featuredEmployees); @endphp
            <div class="establishment-employees w-full">
                <div class="swiper {{ $employeeSliderId }} establishment-employee-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($featuredEmployees as $employeeId)
                            @php
                                $employeeFields = get_fields($employeeId) ?: [];
                                $employeeFirstName = $employeeFields['first_name'] ?? '';
                                $employeeLastName = $employeeFields['last_name'] ?? '';
                                $employeeName = trim($employeeFirstName . ' ' . $employeeLastName) ?: get_the_title($employeeId);
                                $employeeImage = $employeeFields['image'] ?? '';
                                $employeePhone = $employeeFields['phone_number'] ?? '';
                            @endphp
                            <div class="swiper-slide establishment-employee">
                                @if ($employeeImage)
                                    <div class="employee-image shrink-0">
                                        @include('components.image', [
                                            'image_id' => $employeeImage,
                                            'size' => 'thumbnail',
                                            'object_fit' => 'cover',
                                            'img_class' => 'w-full h-full object-cover rounded-full',
                                            'alt' => $employeeName,
                                        ])
                                    </div>
                                @endif
                                <div class="employee-info">
                                    <p class="employee-name">{{ $employeeName }}</p>
                                    @if ($employeePhone)
                                        <a class="employee-phone flex items-center gap-2 w-fit"
                                           href="tel:{{ preg_replace('/[^\d+]/', '', $employeePhone) }}"
                                           title="Bel {{ $employeeName }}">
                                            <i class="fa-solid fa-phone"></i>
                                            <span>{{ $employeePhone }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @if ($employeeCount > 1)
                    <div class="employee-navigation flex shrink-0 gap-2">
                        <button type="button" class="employee-prev employee-prev-{{ $employeeSliderId }}" aria-label="Vorige werknemer"><i class="fa-solid fa-chevron-left"></i></button>
                        <button type="button" class="employee-next employee-next-{{ $employeeSliderId }}" aria-label="Volgende werknemer"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
                @endif
            </div>
            @if ($employeeCount > 1)
                <script>
                    window.addEventListener('DOMContentLoaded', () => {
                        new Swiper('.{{ $employeeSliderId }}', {
                            nested: true,
                            rewind: true,
                            slidesPerView: 1,
                            spaceBetween: 16,
                            navigation: {
                                nextEl: '.employee-next-{{ $employeeSliderId }}',
                                prevEl: '.employee-prev-{{ $employeeSliderId }}',
                            },
                        });
                    });
                </script>
            @endif
        @endif
    </div>
</div>