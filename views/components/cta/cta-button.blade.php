<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0">
        <div class="w-full md:w-2/3 text-center md:text-left">
            @if ($title)
                <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @if ($text)
                <p class="mt-4 md:mt-8 text-{{ $textColor }}">{{ $text }}</p>
            @endif
        </div>
        @if ($buttonText && $buttonLink)
            <div class="w-full md:w-1/3 md:justify-center text-center">
                @include('components.buttons.default', [
                   'text' => $buttonText,
                   'href' => $buttonLink,
                   'alt' => $buttonText,
                   'colors' => 'btn btn-secondary btn-filled',
                   'class' => 'rounded-lg',
               ])
            </div>
        @endif
    </div>
</div>