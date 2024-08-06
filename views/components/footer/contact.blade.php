@php
	$option = get_fields('option');

	if(!empty($option)) {
		if(array_key_exists('footer_establishments', $option)) {
			$footer_establishments = $option['footer_establishments'];
		}
	}

	if(empty($footer_establishments) || empty($footer_establishments[0])) {
		$footer_establishments = [];
		$footer_establishments[] = \Wefabric\WPEstablishments\Establishment::primary();
	}

     if(array_key_exists('title_color', $option)) {
			$title_color = $option['title_color'];
		}
@endphp

<div class="text-base mb-6 leading-7">
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
		@endphp

		<div class="establishments footer-address">
			@if($establishment)
				<p class="establishment-title leading-8 {{ '' ?? $establishment_config['show_title'] }}">
					{{ $establishment->name }}
				</p>
				<p class="establishment-address leading-8">
					@if($establishment->getAddress()->street) {{ $establishment->getAddress()->street }}@endif @if($establishment->getAddress()->full_housenumber > 0) {{ $establishment->getAddress()->full_housenumber }} @endif <br/>
					@if($establishment->getAddress()->postcode) {{ $establishment->getAddress()->postcode }} @endif	@if($establishment->getAddress()->city) {{ $establishment->getAddress()->city }} @endif <br/>
					@if ($countryName) {{ $countryName }} @endif
				</p>

				@if($phone = $establishment->getContactPhone())
					@include('components.link.opening', [
						'href' => $phone->uri(), //comes with a 'tel:' already
						'alt' => 'Telefoonnummer',
						'class' => 'phone-text flex'
					])
					<i class="fa-solid fa-phone mr-4 text-{{ $title_color }} text-md pt-1"></i>
					<span class="inline-block pt-1">{{ $phone->international() }}</span>
					@include('components.link.closing')
				@endif

				@if($email = $establishment->getContactEmailAddress())
					@include('components.link.opening', [
						'href' => 'mailto:'. $email,
						'alt' => 'E-mailadres',
						'class' => 'email-text flex'
					])
					<i class="fa-solid fa-envelope text-{{ $title_color }} mr-4 text-md pt-1"></i>
					<span class="inline-block pt-1">{{ $email }}</span>
					@include('components.link.closing')
				@endif

{{--			 Enable for route--}}
{{--				@if($establishment->getAddress()->street)--}}
{{--					@include('components.link.opening', [--}}
{{--                    'href' => 'https://www.google.com/maps/search/?api=1&query=' . $establishment->getAddress()->street . '+' . $establishment->getAddress()->full_housenumber . $house_number_addition . '+' .  $establishment->getAddress()->postcode  . '+' . $establishment->getAddress()->city ,--}}
{{--                    'alt' => 'Route',--}}
{{--                    'class' => 'route-text flex'--}}
{{--                	])--}}
{{--					<i class="fa-solid fa-route text-{{ $title_color }} mr-4 text-md pt-1"></i>--}}
{{--					<span class="inline-block pt-1">Route</span>--}}
{{--					@include('components.link.closing')--}}
{{--				@endif--}}

				@include('components.establishments.directions')

				@if($establishment->getAcfFields()->get('kvk_number'))
					<div>
						<span class="inline-block pt-1">KVK: {{ $establishment->getAcfFields()->get('kvk_number') }}</span>
					</div>
				@endif

				@if($establishment->getAcfFields()->get('vat_id'))
					<div>
						<span class="inline-block pt-1">BTW: {{ $establishment->getAcfFields()->get('vat_id') }}</span>
					</div>
				@endif
			@endif
		</div>
	@endforeach
</div>
