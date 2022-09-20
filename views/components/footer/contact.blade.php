@php $establishment = \Wefabric\WPEstablishments\Establishment::primary(); @endphp
<div class="text-base mb-6 leading-7">
    <div class=" pt-2 mb-4">
        @if($establishment)
            <p>{{ $establishment->name }}</p>
            <p>{{ $establishment->getAddress()->street }} {{ $establishment->getAddress()->full_housenumber }}</p>
            <p>{{ $establishment->getAddress()->postcode }} {{ $establishment->getAddress()->city }}</p>
        @endif
    </div>

    @if($establishment && $phone = $establishment->getContactPhone())
        @include('components.link.opening', [
            'href' => $phone->uri(), //comes with a 'tel:' already
            'alt' => 'Telefoonnummer',
            'class' => 'flex mb-2 no-underline',
        ])
            <i class="fa-solid fa-phone mr-4 text-md pt-1"></i>
            <span class="inline-block pt-1 cursor-pointer">{{ $phone }}</span>
        @include('components.link.closing')
    @endif

    @if($establishment && $email = $establishment->getContactEmailAddress())
        @include('components.link.opening', [
            'href' => 'mailto:'. $email,
            'alt' => 'E-mailadres',
            'class' => 'flex mb-2 no-underline',
        ])
            <i class="fa-solid fa-envelope mr-4 text-md pt-1"></i>
            <span class="inline-block pt-1 cursor-pointer">{{ $email }}</span>
        @include('components.link.closing')
    @endif

    @if($establishment)
        @include('components.establishments.directions')
    @endif

</div>