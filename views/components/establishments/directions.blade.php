@php
	$address = $establishment->getAddress();
@endphp

@if($establishment->getAcfFields()->get('allow_route') && !empty($address->street) && !in_array(strtolower($address->street), ['postbus', 'antwoordnummer']))
	@include('components.link.opening', [
		   'href' => $address->getGoogleMapsUrl(),
		   'alt' => 'Adres op Google Maps',
		   'class' => 'flex'
	   ])
	<i class="fa-solid fa-location-dot mr-4 ml-1 text-md pt-1"></i>
	<span class="inline-block pt-1">Routebeschrijving</span>
	@include('components.link.closing')
@endif