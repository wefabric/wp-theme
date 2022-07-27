@include('components.link.opening', [
    'href' => $href,
    'alt' => $alt ?? $text,
    'rel' => $rel ?? '',
    'target' => $target ?? '',
    'class' => $a_class ?? '',
])

    @php
        if(!isset($colors)) {
            $colors = 'btn-white hover:btn-primary-dark text-black hover:text-white';
        }
    @endphp

    <span class="btn {{ $size ?? 'btn-small' }} {{ $colors }} {{ $class ?? 'font-bold' }}">
        {{ $text }}
    </span>
@include('components.link.closing')