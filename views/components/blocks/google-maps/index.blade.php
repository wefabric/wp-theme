<x-wefabric:section block-type="google-maps" :block="$block" :random-number="$randomNumber">
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="mx-auto {{ $blockClass }}">
            <div class="text-block {{ $textClass }}">
                <x-wefabric:title :block="$block" />

                @if ($text)
                    <x-wefabric:content :content="$text"
                                        :class="'mb-8 text-' . $textColor . ($blockWidth == 'fullscreen' ? ' ' : '')"></x-wefabric:content>
                @endif
            </div>

            <iframe width="100%" height="600"
                    class="h-[300px] md:h-[400px] xl:h-[600px]"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                    src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $mapsCity }} {{ $mapsStreet }} {{$mapsHouseNumber}}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
            </iframe>

            @if ($buttons && $buttons->count() >= 1)
                <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} @if($blockWidth != 'fullscreen') container mx-auto @endif">
                    @foreach ($buttons as $button)
                        {!! $button->render()->render() !!}
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-wefabric:section>
