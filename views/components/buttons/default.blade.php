{{--@php--}}
{{--    /* @var \Illuminate\Database\Eloquent\Collection $button */--}}
{{--    if(!empty($button)) {--}}

{{--        if(empty($href) && (!empty($button->get('external_link')) || !empty($button->get('internal_link')))) {--}}
{{--            $href = empty($button->get('external_link')) ? $button->get('internal_link') : $button->get('external_link');--}}
{{--        }--}}

{{--        if(empty($text) && !empty($button->get('button_text'))) {--}}
{{--            $text = $button->get('button_text');--}}
{{--        }--}}

{{--		if(empty($colors)) {--}}
{{--			$colors = '';--}}
{{--            if(!empty($button->get('bg_color'))) {--}}
{{--                $colors .= ' btn-'. $button->get('bg_color');--}}
{{--            }--}}

{{--            if(!empty($button->get('text_color'))) {--}}
{{--                $colors .= ' text-'. $button->get('text_color');--}}
{{--            }--}}
{{--		}--}}
{{--	}--}}

{{--    if(!isset($colors)) {--}}
{{--        $colors = 'btn-white text-black hover:text-white';--}}
{{--    }--}}
{{--@endphp--}}

@if(!empty($href) && !empty($text))
    @include('components.link.opening', [
        'href' => $href,
        'alt' => $alt ?? $text,
        'rel' => $rel ?? '',
        'target' => $target ?? '',
        'class' => ($a_class ?? ''). 'w-fit no-underline',
    ])
        <span class="btn {{ $size ?? '' }} {{ $colors }} {{ $class ?? '' }}">
            {{ $text }}
            @if($icon ?? '')
                <i class="{{ $icon }}"></i>
            @endif
        </span>
    @include('components.link.closing')
@endif