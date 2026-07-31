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

    $establishmentPhone = $establishmentModel->getContactPhone();
    $establishmentEmail = $establishmentModel->getEmailAddress();
    $establishmentWhatsapp = $establishmentModel->whatsapp_number ?? '';
    $establishmentKvkNumber = $establishmentModel->coc_number ?? '';
    $establishmentVatNumber = $establishmentModel->vat_number ?? '';
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
            </div>
        </div>
    </div>
</div>