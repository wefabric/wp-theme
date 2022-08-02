@php
    /* @var \Illuminate\Database\Eloquent\Collection $button */
    if(!empty($button)) {

        if(empty($href) && (!empty($button->get('external_link')) || !empty($button->get('internal_link')))) {
            $href = empty($button->get('external_link')) ? $button->get('internal_link') : $button->get('external_link');
        }

        if(empty($text) && !empty($button->get('button_text'))) {
            $text = $button->get('button_text');
        }

	}

    if(!isset($colors)) {
        $colors = 'btn-white hover:btn-primary-dark text-black hover:text-white';
    }
@endphp

@if(!empty($href) && !empty($text))
    @include('components.link.opening', [
        'href' => $href,
        'alt' => $alt ?? $text,
        'rel' => $rel ?? '',
        'target' => $target ?? '',
        'class' => $a_class ?? '',
    ])
        <span class="btn {{ $size ?? 'btn-small' }} {{ $colors }} {{ $class ?? 'font-bold' }}">
            {{ $text }}
        </span>
    @include('components.link.closing')
@endif