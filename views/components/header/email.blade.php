@php
    $establishment = \Wefabric\WPEstablishments\Establishment::primary();
    $email = $establishment !== null ?? $establishment->getContactEmailAddress();
	$alt = 'Stuur een mail naar '. $email;
@endphp

@if($email)
    @include('components.link.opening', [
        'href' => 'mailto:'. $email,
        'class' => $a_class ?? '',
        'alt' => $alt,
    ])

        <span class="fa-regular fa-circle-envelope {{ $class }}"></span>
        <span class="screen-reader-only">
            {{ $alt }}
        </span>

    @include('components.link.closing')
@endif