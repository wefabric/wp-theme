@php
    $option = get_fields('option');
    if (is_array($option) && isset($option['title_color'])) {
        $title_color = $option['title_color'];
    }
@endphp

@if(!empty($option) && array_key_exists('channels', $option))
    <div class="socials mb-4 flex gap-3 items-center flex-wrap">
        @foreach($option['channels'] as $social)
            <a class="group footer-social social-{{ strtolower($social['name']) }} hover:text-{{ $title_color }}"
               href="{{ $social['url'] }}" title="{{ $social['name'] }} pagina" alt="{{ $social['name'] }}" target="_blank"
               aria-label="Ga naar {{ $social['name'] }}">
                <i class="{{ $social['icon'] }} text-xl hover:text-{{ $title_color }} transition-all group-hover:scale-110"></i>
            </a>
        @endforeach
    </div>
@endif