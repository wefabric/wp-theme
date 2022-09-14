@php
    $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    $phone = $establishment?->getContactPhone();
	$alt = 'Bel naar '. ($phone ?? '');
@endphp

@if($phone)
    @include('components.link.opening', [
        'href' => 'tel:'. $phone,
        'class' => $a_class ?? '',
        'alt' => $alt,
    ])

    <span class="fa-regular fa-circle-phone {{ $class }}"></span>
    <span class="screen-reader-only">
        {{ $alt }}
    </span>

    @include('components.link.closing')
@endif