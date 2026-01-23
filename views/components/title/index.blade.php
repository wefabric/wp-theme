@if ($subTitle)
    <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">
        @if ($subtitleIcon)
            <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
        @endif
        {!! $subTitle !!}
    </span>
@endif

@if ($title)
    <h2 class="title mb-4 text-{{ $titleColor }} @if ($titleAnimation) title-animation @endif @if ($flyInAnimation) flyin-animation @endif">{!! $title !!}</h2>
@endif