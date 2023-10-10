<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0">
        <div class="w-full md:w-2/3 text-center md:text-left">
            <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
            @if (!empty($text))
                <p class="mt-4 md:mt-8 text-{{$textColor}}">{{ $text }}</p>
            @endif
        </div>
        @if (!empty($ctaImage))
            <div class="w-full md:w-1/3 md:justify-center text-center md:mt-[-100px]">
                {!! wp_get_attachment_image($block['data']['image'], 'full', false, ['class' => 'w-full object-cover', 'alt' => get_post_meta($block['data']['image'], '_wp_attachment_image_alt', true)]) !!}
            </div>
        @endif
    </div>
    <div>
        @if (!empty($ctaForm))
            <div class="w-full mt-10">
                {!! gravity_form($ctaForm, false) ; !!}
            </div>
        @endif
    </div>
</div>