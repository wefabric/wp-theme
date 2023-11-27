@php
    $option = get_fields('option');
@endphp

@if(!empty($option) && array_key_exists('channels', $option))
    <div class="mb-8 flex gap-4 items-center">
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
                <a class="group footer-social" href="{{ $social['url'] }}" alt="{{ $social['name'] }}" target="_blank"><i class="{{ $social['icon'] }} text-xl hover:text-secondary transition-all group-hover:scale-110"></i></a>
            @endforeach
    </div>
@endif