@php
	$options = get_fields('option');
	
	$establishment = \Wefabric\WPEstablishments\Establishment::primary();
	$fields = collect(get_fields($establishment->post->ID));

	/* @var WP_Post $establishment_config */
//	$establishment = new \Wefabric\WPEstablishments\Establishment($establishment_id);
//
//
@endphp

<div class="widget widget-address">
	<div class=" border-b-[1px] pb-4 border-[#DED8FF]">

		@if($show_title ?? true)
			<h2 class="text-lg  mb-6">{{ 'Contact' }}</h2>
		@endif
		<p class="leading-7 mb-4">{{--Adress--}}
			{{ $establishment->name }} <br/>
			{{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }}
			<br/>
			{{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}
		</p>

		@include('components.establishments.directions')
	</div>

	@if($fields->get('contact_email') || $fields->get('contact_phone'))
		<div class="border-b-[1px] py-6 border-[#DED8FF]">
			@if($fields->get('contact_email'))
				<a href="mailto:{{ $fields->get('contact_email') }}" class="block group flex align-middle">
					<i class="fa-solid fa-envelope-open mr-4"></i>
					<span class="group-hover:underline self-center">{{ $fields->get('contact_email') }}</span>
				</a>
			@endif
			@if($fields->get('contact_phone'))
				<a href="tel:{{ $fields->get('contact_phone') }}" class=" block group flex align-middle @if($fields->get('contact_email')) mt-1 @endif">
					<i class="fa-solid fa-circle-phone mr-4"></i>
					<span class="group-hover:underline self-center">{{ $fields->get('contact_phone') }}</span>
				</a>
			@endif
		</div>
	@endif

	@if($fields->get('kvk_number') || $fields->get('vat_id')  )
		<div class="py-6">
			@if($fields->get('kvk_number'))
				<span class="block text-sm leading-7 text-{{ $block->get('text_color') }}">
                                            {{ 'KVK: ' . $fields->get('kvk_number') }}
                                        </span>
			@endif
			@if($fields->get('vat_id'))
				<span class="block text-sm leading-7 text-{{ $block->get('text_color') }}">
                                            {{ 'BTW: ' . $fields->get('vat_id') }}
                                        </span>
			@endif
		</div>
	@endif
</div>
