<a href="{{ $href }}"

    alt="{{ $alt }}"
    aria-label="{{ $alt }}"

    @if(!empty($class))
       class="{{ $class }}"
    @endif

    @if(!empty($rel))
        rel="{{ $rel }}"
    @endif

    @if(!empty($target))
       target="{{ $target }}"
    @endif
>