<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="flex flex-col md:flex-row md:items-center gap-x-8 gap-y-4 md:gap-y-0">
        <div class="w-full text-center md:text-left">
            @if ($title)
                <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @if ($text)
                <p class="mt-4 md:mt-8 text-{{ $textColor }}">{{ $text }}</p>
            @endif
        </div>
        @if (($button1Text) && ($button1Link))
            <div class="flex gap-4 w-full md:w-fit justify-center md:justify-end">
                @include('components.buttons.default', [
                   'text' => $button1Text,
                   'href' => $button1Link,
                   'alt' => $button1Text,
                   'colors' => 'btn btn-' . $button1Color . ' btn-' . $button1Style . '',
                   'class' => 'rounded-lg',
                   'target' => $button1Target,
               ])
                @if (($button2Text) && ($button2Link))
                    @include('components.buttons.default', [
                       'text' => $button2Text,
                       'href' => $button2Link,
                       'alt' => $button2Text,
                       'colors' => 'btn btn-' . $button2Color . ' btn-' . $button2Style . '',
                       'class' => 'rounded-lg',
                       'target' => $button2Target,
                   ])
                @endif
            </div>
        @endif
    </div>
</div>