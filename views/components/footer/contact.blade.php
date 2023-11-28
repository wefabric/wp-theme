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
			if($establishment_config) {
                $establishment = new \Wefabric\WPEstablishments\Establishment($establishment_config['establishment']);
			}
		@endphp

		<div class="mb-10 footer-address">
			@if($establishment)
				<p class="leading-8 {{ '' ?? $establishment_config['show_title'] }}">
					{{ $establishment->name }}
				</p>
				<p class="leading-8">
					{{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }} <br/>
					{{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}
				</p>

				@if($phone = $establishment->getContactPhone())
					@include('components.link.opening', [
						'href' => $phone->uri(), //comes with a 'tel:' already
						'alt' => 'Telefoonnummer',
						'class' => 'flex'
					])
					<i class="fa-solid fa-phone mr-4 text-{{ $title_color }} text-md pt-1"></i>
					<span class="inline-block pt-1">{{ $phone->national() }}</span>
					@include('components.link.closing')
				@endif

				@if($email = $establishment->getContactEmailAddress())
					@include('components.link.opening', [
						'href' => 'mailto:'. $email,
						'alt' => 'E-mailadres',
						'class' => 'flex'
					])
					<i class="fa-solid fa-envelope text-{{ $title_color }} mr-4 text-md pt-1"></i>
					<span class="inline-block pt-1">{{ $email }}</span>
					@include('components.link.closing')
				@endif

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