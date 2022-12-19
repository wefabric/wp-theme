@php
    $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    $phone = $establishment?->getContactPhone();
	$alt = 'Bel naar '. ($phone ?? '');
@endphp

@if($phone)
    @include('components.link.opening', [
        'href' => $phone->uri(),
        'class' => $a_class ?? '',
        'alt' => $alt,
    ])

    <i class="fa-regular fa-circle-phone {{ $class }}"></i>
    <span class="screen-reader-only">
        {{ $alt }}
    </span>

    @include('components.link.closing')
@endif