@php
    $option = get_fields('option');
    if(array_key_exists('title_color', $option)) {
        $title_color = $option['title_color'];
    }
@endphp

@if(!empty($option) && array_key_exists('channels', $option))
    <div class="socials mb-4 flex gap-4 items-center">
        {{--        @foreach($option['channels'] as $social)--}}
        {{--            @include('components.buttons.icon', [--}}
        {{--	            'href' => $social['url'],--}}
        {{--	            'alt' => $social['name'],--}}
        {{--	            'rel' => 'noopener',--}}
        {{--	            'target' => '_blank',--}}
        {{--	            'icon' => $social['icon'] .' text-xl',--}}
        {{--	            'a_class' => 'no-underline '--}}
        {{--            ])--}}
        {{--        @endforeach--}}
        @foreach($option['channels'] as $social)
            <a class="group footer-social hover:text-{{ $title_color }}" href="{{ $social['url'] }}" alt="{{ $social['name'] }}" target="_blank" aria-label="Ga naar {{ $social['name'] }}"><i
                        class="{{ $social['icon'] }} text-xl hover:text-{{ $title_color }} transition-all group-hover:scale-110"></i></a>
        @endforeach
    </div>
@endif