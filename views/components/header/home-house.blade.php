@php
    $alt = 'Naar de homepagina';
@endphp

@include('components.link.opening', [
    'href' => get_home_url(),
    'class' => $a_class ?? '',
    'alt' => $alt,
])

    <span class="fa-solid fa-house {{ $class }}"></span>
    <span class="screen-reader-only">
        {{ $alt }}
    </span>

@include('components.link.closing')