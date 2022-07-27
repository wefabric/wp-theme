@include('components.link.opening', [
    'href' => $href,
    'alt' => $alt ?? $text,
    'rel' => $rel ?? '',
    'target' => $target ?? '',
    'class' => $a_class ?? '',
])
    <span class="btn {{ $size ?? 'btn-small' }} btn-{{ $color ?? 'primary-dark' }} {{ $class ?? '' }}">
        {{ $text }}
    </span>
@include('components.link.closing')