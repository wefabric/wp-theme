@php
	$option = get_fields('option');
    $establishmentElements = $option['footer_establishment_information']['establishment_elements'] ?? [];
    $customEstablishmentText = $option['footer_establishment_information']['custom_establishment_text'] ?? '';

	if(!empty($option)) {
		if(array_key_exists('footer_establishments', $option)) {
			$footer_establishments = $option['footer_establishments'];
		}
	}

	if(empty($footer_establishments) || empty($footer_establishments[0])) {
		$footer_establishments = [];
		$footer_establishments[] = \Wefabric\WPEstablishments\Establishment::primary();
	}

    if (is_array($option) && isset($option['title_color'])) {
    	$title_color = $option['title_color'];
	}
@endphp

<div class="establishments flex flex-col gap-y-6 text-base leading-7">
	@foreach($footer_establishments as $key => $establishment_config)
		@php
			/* @var WP_Post $establishment_config */
			$establishment = null;
            if ($establishment_config instanceof \Wefabric\WPEstablishments\Establishment) {
                $establishment = $establishment_config;
            } elseif (is_array($establishment_config) && array_key_exists('establishment', $establishment_config)) {
                $establishment = new \Wefabric\WPEstablishments\Establishment($establishment_config['establishment']);
            }

            $countryName = '';
			if($establishment) {
				$country_id = $establishment->getAddress()->country_id;
				$countryNames = [
					'NL' => 'The Netherlands',
				];
				$countryName = isset($countryNames[$country_id]) ? $countryNames[$country_id] : $country_id;
			}

			$acfData = get_fields($establishment->post->ID);
			$opening_hours = $acfData['opening_hours'] ?? [];

            $vatNumber = $acfData['vat_number'] ?? null;
            $cocNumber = $acfData['coc_number'] ?? null;
		@endphp

		<div class="establishment-item footer-address flex flex-col gap-y-4">
			@if($establishment)

				<div class="location-section">

					{{-- Establishment Name --}}
					@if(in_array('establishment_name', $establishmentElements))
						<div class="establishment-title leading-8 {{ $establishment_config['show_title'] ?? '' }}">
							{{ $establishment->name }}
						</div>
					@endif

					{{-- Establishment Address --}}
					@if(in_array('establishment_address', $establishmentElements) || in_array('establishment_country', $establishmentElements))
						<div class="establishment-address leading-8">
							@if($establishment->getAddress()->street)
								{{ $establishment->getAddress()->street }}
							@endif
							@if($establishment->getAddress()->full_housenumber > 0)
								{{ $establishment->getAddress()->full_housenumber }}
							@endif
							<br/>
							@if($establishment->getAddress()->postcode)
								{{ $establishment->getAddress()->postcode }}
							@endif
							@if($establishment->getAddress()->city)
								{{ $establishment->getAddress()->city }}
							@endif
							<br/>
							{{-- Establishment Country --}}
							@if(in_array('establishment_country', $establishmentElements) && $countryName)
								{{ $countryName }}
							@endif



                        </div>
					@endif
				</div>

				<div class="contact-info">

					{{-- Establishment Phone --}}
					@if(in_array('establishment_phone', $establishmentElements) && $phone = $establishment->getContactPhone())
						@include('components.link.opening', [
							'href' => $phone->uri(),
							'alt' => 'Telefoonnummer',
							'class' => 'phone-text flex w-fit'
						])
						<i class="fa-solid fa-phone mr-4 text-{{ $title_color }} text-md pt-1"></i>
						<span class="inline-block pt-1">{{ get_bloginfo("language") === 'nl-NL' ? $phone->national() : $phone->international() }}</span>
						@include('components.link.closing')
					@endif

					{{-- Establishment Email --}}
					@if(in_array('establishment_mail', $establishmentElements) && $email = $establishment->getContactEmailAddress())
						@include('components.link.opening', [
							'href' => 'mailto:' . $email,
							'alt' => 'E-mailadres',
							'class' => 'email-text flex w-fit'
						])
						<i class="fa-solid fa-envelope text-{{ $title_color }} mr-4 text-md pt-1"></i>
						<span class="inline-block pt-1">{{ $email }}</span>
						@include('components.link.closing')
					@endif

					{{-- Establishment Route --}}
					@if(in_array('establishment_route', $establishmentElements) && $establishment->getAddress()->street)
						@include('components.link.opening', [
						'href' => 'https://www.google.com/maps/search/?api=1&query=' . $establishment->getAddress()->street . '+' . $establishment->getAddress()->full_housenumber . $house_number_addition . '+' .  $establishment->getAddress()->postcode  . '+' . $establishment->getAddress()->city ,
						'alt' => 'Route',
						'class' => 'route-text flex w-fit'
						])
						<i class="fa-solid fa-route text-{{ $title_color }} mr-4 text-md pt-1"></i>
						<span class="inline-block pt-1">Route</span>
						@include('components.link.closing')
					@endif
				</div>

				@include('components.footer.establishment-opening-hours', [
					'establishmentElements' => $establishmentElements,
					'establishment' => $establishment,
					'opening_hours' => $opening_hours
				])

                @if((in_array('establishment_vat_number', $establishmentElements) && $vatNumber) || (in_array('establishment_coc_number', $establishmentElements) && $cocNumber))
                    <div class="establishment-numbers mt-2">

                        @if(in_array('establishment_vat_number', $establishmentElements) && $vatNumber)
                            <div class="establishment-vat">
                                BTW: {{ $vatNumber }}
                            </div>
                        @endif

                        @if(in_array('establishment_coc_number', $establishmentElements) && $cocNumber)
                            <div class="establishment-coc">
                                KvK: {{ $cocNumber }}
                            </div>
                        @endif

                    </div>
                @endif


            @endif

		</div>
	@endforeach

	{{-- Establishment Text --}}
	@if ($customEstablishmentText)
		<div class="custom-establishment-text mt-2">
			{!! $customEstablishmentText !!}
		</div>
	@endif
</div>