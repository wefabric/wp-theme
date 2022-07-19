@php $establishment = \Wefabric\WPEstablishments\Establishment::primary(); @endphp
<div class="text-base mb-6 leading-7">
    <div class="content pt-2 mb-4">
        <p>{{ $establishment->name }}</p>
        <p>{{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }}</p>
        <p>{{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}</p>
    </div>

    @if($phone = $establishment->getContactPhone())
        @include('components.link.opening', [
            'href' => $phone->uri(), //comes with a 'tel:' already
            'alt' => 'Telefoonnummer',
            'class' => 'flex mb-2'
        ])
            <i class="fa-solid fa-phone mr-4 text-md pt-1"></i>
            <span class="inline-block pt-1 cursor-pointer hover:underline">{{ $phone }}</span>
        @include('components.link.closing')
    @endif

    @if($email = $establishment->getContactEmailAddress())
        @include('components.link.opening', [
            'href' => 'mailto:'. $email,
            'alt' => 'E-mailadres',
            'class' => 'flex mb-2'
        ])
            <i class="fa-solid fa-envelope mr-4 text-md pt-1"></i>
            <span class="inline-block pt-1 cursor-pointer hover:underline">{{ $email }}</span>
        @include('components.link.closing')
    @endif

    @include('components.link.opening', [
	    'href' => $establishment->getAddress()->getGoogleMapsUrl(),
	    'alt' => 'Adres op Google Maps',
	    'class' => 'flex mb-2'
    ])
        <i class="fa-solid fa-location-dot mr-4 ml-1 text-md pt-1"></i>
        <span class="inline-block pt-1 cursor-pointer hover:underline">Routebeschrijving</span>
    @include('components.link.closing')

</div>