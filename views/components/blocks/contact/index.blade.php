<x-wefabric:section block-type="contact" :block="$block" :random-number="$randomNumber">
    <div class="custom-styling relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="custom-layout {{ $blockClass }} mx-auto flex flex-col lg:flex-row gap-2 lg:gap-8">
            <div class="content-block h-fit w-full {{ $contentClass }} order-1 @if ($formPosition == 'right') lg:order-0 @else lg:order-1 @endif py-8 px-8 lg:py-12 bg-{{ $contentBackgroundColor }}">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if($blockWidth == 'fullscreen') px-8 @endif {{ $textClass }}">
                        @if ($subtitleIcon)
                            <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                        @endif
                        {!! $subTitle !!}
                    </span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                <div class="flex flex-col content-layout">
                    @if ($establishment_query->have_posts())
                        <div class="establishment-list flex flex-col gap-y-8">
                            @while ($establishment_query->have_posts())
                                @php
                                    $establishment_query->the_post();
                                    $establishment = new \Wefabric\WPEstablishments\Establishment( get_the_ID());
                                    $establishment_title = $establishment->post->post_title;
                                    $establishment_id = $establishment->post->ID;
                                    $street = $establishment->getAddress()->street;
                                    $postcode = $establishment->getAddress()->postcode;
                                    $house_number = $establishment->getAddress()->housenumber;
                                    $house_number_addition = $establishment->getAddress()->house_number_addition;
                                    $city = $establishment->getAddress()->city;
                                    $phone = $establishment->getContactPhone();
                                    $email = $establishment->getEmailAddress();
                                    $country_id = $establishment->getAddress()->country_id;
                                    $cocNumber = get_post_meta($establishment_id, 'coc_number', true);
                                    $vatNumber = get_post_meta($establishment_id, 'vat_number', true);
                                    $countryName = '';
                                    if($country_id) {
                                        $countryNames = [
                                            'NL' => 'The Netherlands',
                                            'BR' => 'Brazil',
                                        ];
                                        $countryName = $countryNames[$country_id] ?? $country_id;
                                    }

                                    $establishmentSchema = [
                                        '@type' => 'LocalBusiness',
                                        'name' => $establishment_title,
                                        'image' => get_site_icon_url(),
                                        'address' => [
                                            '@type' => 'PostalAddress',
                                            'streetAddress' => trim($street . ' ' . $house_number . ' ' . $house_number_addition),
                                            'addressLocality' => $city,
                                            'postalCode' => $postcode,
                                            'addressCountry' => $country_id ?: 'NL',
                                        ],
                                    ];

                                    if ($phone) {
                                        $establishmentSchema['telephone'] = $phone->international();
                                    }
                                    if ($email) {
                                        $establishmentSchema['email'] = $email;
                                    }

                                    $openingHours = $establishment->openingHours();
                                    if ($openingHours->isNotEmpty()) {
                                        $establishmentSchema['openingHoursSpecification'] = [];
                                        foreach ($openingHours as $hour) {
                                            if ($hour->isClosed()) continue;

                                            $spec = [
                                                '@type' => 'OpeningHoursSpecification',
                                                'dayOfWeek' => $hour->day,
                                                'opens' => $hour->openingHour,
                                                'closes' => $hour->closingHour,
                                            ];
                                            $establishmentSchema['openingHoursSpecification'][] = $spec;

                                            if (!empty($hour->openingHour2) && !empty($hour->closingHour2)) {
                                                $establishmentSchema['openingHoursSpecification'][] = [
                                                    '@type' => 'OpeningHoursSpecification',
                                                    'dayOfWeek' => $hour->day,
                                                    'opens' => $hour->openingHour2,
                                                    'closes' => $hour->closingHour2,
                                                ];
                                            }
                                        }
                                    }
                                    \Wefabric\WPSupport\Schema\JsonLd::addSchema('establishment_' . $establishment_id, $establishmentSchema);
                                @endphp

                                <div class="establishment flex flex-col gap-y-6 text-{{ $textColor }}">

                                    {{-- Vestiging gegevens --}}
                                    @if (!empty($visibleElements) && array_intersect(['establishment_name', 'establishment_address', 'establishment_country'], $visibleElements))
                                        <div class="location-section">
                                            @if (in_array('establishment_name', $visibleElements))
                                                <div class="establishment-title font-bold mb-2">{{ $establishment_title }}</div>
                                            @endif

                                            @if (in_array('establishment_address', $visibleElements))
                                                <div class="establishment-address">{{ $street }} {{ $house_number }} {{ $house_number_addition }}</div>
                                                <div class="establishment-zipcode">{{ $postcode }} {{ $city }}</div>
                                            @endif

                                            @if (in_array('establishment_country', $visibleElements) && $countryName)
                                                <div class="establishment-country">{{ $countryName }}</div>
                                            @endif

                                             @if (in_array('establishment_vat_number', $visibleElements) && $vatNumber)
                                                <div class="establishment-vat mt-2">BTW nummer: {{ $vatNumber }}</div>
                                             @endif

                                             @if (in_array('establishment_coc_number', $visibleElements) && $cocNumber)
                                                <div class="establishment-coc">KvK: {{ $cocNumber }}</div>
                                             @endif
                                        </div>
                                    @endif

                                    {{-- Contactgegevens --}}
                                    @if (!empty($visibleElements) &&
                                        (
                                            (in_array('establishment_phone', $visibleElements) && $phone) ||
                                            (in_array('establishment_mail', $visibleElements) && $email) ||
                                            in_array('establishment_route', $visibleElements)
                                        )
                                    )
                                        <div class="contact-info">
                                            <div class="contact-text font-bold mb-2">Contact</div>
                                            <div class="flex-layout flex flex-col gap-y-2">
                                                @if (in_array('establishment_phone', $visibleElements) && $phone)
                                                    <a class="phone-link group flex items-center gap-2 w-fit"
                                                       href="{{ $phone->uri() }}"
                                                       title="Telefoonnummer">
                                                        <i class="fa-solid fa-phone text-primary"></i>
                                                        <span class="align-middle group-hover:text-primary group-hover:underline">{{ get_bloginfo("language") === 'nl-NL' ? $phone->national() : $phone->international() }}</span>
                                                    </a>
                                                @endif

                                                @if (in_array('establishment_mail', $visibleElements) && $email)
                                                    <a class="email-link group flex items-center gap-2 w-fit"
                                                       href="mailto:{{ $email }}"
                                                       title="Email">
                                                        <i class="fa-solid fa-envelope text-primary"></i>
                                                        <span class="align-middle group-hover:text-primary group-hover:underline">{{ $email }}</span>
                                                    </a>
                                                @endif

                                                @if (in_array('establishment_route', $visibleElements))
                                                    <div class="route-info">
                                                        <a class="route-link group flex items-center gap-2 w-fit"
                                                           href="https://www.google.com/maps/search/?api=1&query={{ $street }}+{{ $house_number }}{{ $house_number_addition }}+{{ $postcode }}+{{ $city }}"
                                                           title="Route">
                                                            <i class="fa-solid fa-route text-primary"></i>
                                                            <span class="align-middle group-hover:text-primary group-hover:underline">Route</span>
                                                        </a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif

                                    @php
                                        $options = function_exists('get_fields') ? get_fields('option') : [];
                                    @endphp
                                    @if (in_array('socials', $visibleElements) && !empty($options) && !empty($options['channels']))
                                        <div class="socials text-{{ $textColor }}">
                                            <div class="socials-text font-bold mb-2">Volg ons</div>
                                            <div class="socials flex gap-3 items-center flex-wrap">
                                                @foreach($options['channels'] as $social)
                                                    <a class="group footer-social social-{{ strtolower($social['name']) }}"
                                                       href="{{ $social['url'] }}" title="{{ $social['name'] }} pagina" alt="{{ $social['name'] }}" target="_blank"
                                                       aria-label="Ga naar {{ $social['name'] }}">
                                                        <i class="{{ $social['icon'] }} text-xl transition-all group-hover:scale-110"></i>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif


                                    {{-- Openingstijden --}}
                                    @if (in_array('establishment_opening_hours', $visibleElements) && $establishment->openingHours()->isNotEmpty())
                                        <div class="opening-hours-section">
                                            <div class="opening-hours-text font-bold mb-2">Openingstijden</div>
                                            <div class="flex flex-col">
                                                @foreach ($establishment->openingHours() as $openingHour)

                                                    <div class="flex items-center sm:gap-x-12 justify-between sm:justify-start">
                                                        <span class="w-fit sm:w-[120px]">{{ $openingHour->day }}</span>
                                                        @if ($openingHour->isClosed())
                                                            <span>Gesloten</span>
                                                        @else
                                                            <span> {{ $openingHour->openingHour }} uur - {{  $openingHour->closingHour }} uur
                                                                @if (!empty($openingHour->openingHour2) && !empty($openingHour->closingHour2))
                                                                    & {{ $openingHour->openingHour2 }} uur
                                                                    - {{ $openingHour->closingHour2 }} uur
                                                                @endif
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            @endwhile
                            @php wp_reset_postdata(); @endphp
                        </div>
                    @endif
                    @if ($text)
                        <x-wefabric:content :content="$text" :class="'mt-4 text-' . $textColor"></x-wefabric:content>
                    @endif
                </div>
            </div>

            @if ($form)
                <div class="form-block w-full {{ $formClass }} order-0 @if ($formPosition == 'right') lg:order-1 @else lg:order-0 @endif">
                    <div class="contact-block bg-{{ $formBackgroundColor }} p-8 lg:p-12 {{ $borderRadius }}">
                        <div class="form h-full w-full">
                            @if ($formTitle)
                                <h2 class="form-title mb-4 text-{{ $formTitleColor }}">{!! $formTitle !!}</h2>
                            @endif
                            {!! gravity_form($form, false) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-wefabric:section>
