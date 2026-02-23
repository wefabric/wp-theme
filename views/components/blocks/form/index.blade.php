<x-wefabric:section block-type="formulier" :block="$block" :random-number="$randomNumber">
    <div class="custom-styling relative z-10 @if (!$formBackgroundColor) px-8 @endif sm:px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            <x-wefabric:title :block="$block" :class="$formBackgroundColor ? 'px-8 sm:px-0' : ''" />
            @if ($text)
                <x-wefabric:content :content="$text" :class="'mb-8 text-' . $textColor . ' ' . $textClass . ($blockWidth == 'fullscreen' ? ' ' : '') . ($formBackgroundColor ? ' px-8 sm:px-0' : '')"></x-wefabric:content>
            @endif

            @if ($form)
                <div class="form @if ($formBackgroundColor) p-8 md:p-16 @endif {{ $formBackgroundColor }} bg-{{ $formBackgroundColor }}">
                    @if ($formSubTitle)
                        <span class="subtitle block mb-2 @if($formSubTitleColor) text-{{ $formSubTitleColor }} @endif @if ($formBackgroundColor) px-8 sm:px-0 @endif">{!! $formSubTitle !!}</span>
                    @endif
                    @if ($formTitle)
                        <h2 class="title mb-4 @if($formTitleColor) text-{{ $formTitleColor }} @endif @if ($formBackgroundColor) px-8 sm:px-0 @endif">{!! $formTitle !!}</h2>
                    @endif
                    {!! gravity_form($form, false) !!}
                </div>
            @endif

            @if ($buttons && $buttons->count() >= 1)
                <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">
                    @foreach($buttons as $button)
                        {!! $button->render()->render() !!}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-wefabric:section>

@if ($formTextColor || $formInputColor)
    <style>
        @if ($formTextColor)
        .block-{{ $randomNumber }} form label,
        .block-{{ $randomNumber }} form legend,
        .block-{{ $randomNumber }} form .gfield_description {
            color:
            @if ($formTextColor === 'white') white !important
            @elseif ($formTextColor === 'black') black !important;
            @else var(--{{ $formTextColor }}) !important;
            @endif
        }
        @endif

        @if ($formInputColor)
        .block-{{ $randomNumber }} form input,
        .block-{{ $randomNumber }} form textarea {
            background-color:
            @if ($formInputColor === 'white') white !important
            @elseif ($formInputColor === 'black') black !important;
            @else var(--{{ $formInputColor }}) !important;
            @endif
        }
        @endif
    </style>
@endif
