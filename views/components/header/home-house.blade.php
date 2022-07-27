@include('components.link.opening', [
    'href' => get_home_url(),
    'class' => $class,
    'alt' => 'Naar de homepagina',
])

    <span class="fa-solid fa-house text-primary-dark"></span>
    <span class="screen-reader-only">
        Naar de homepagina
    </span>

@include('components.link.closing')