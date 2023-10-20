@php
    $alt = get_post_meta($ctaImage, '_wp_attachment_image_alt', true) ?: 'whitepaper';
@endphp

<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0">
        <div class="w-full @if($ctaImage) md:w-2/3 @else md:w-full @endif text-center md:{{ $textClass }}">
            @if ($title)
                <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @if ($text)
                <p class="mt-4 md:mt-8 text-{{ $textColor }}">{{ $text }}</p>
            @endif
        </div>
        @if ($ctaImage)
            <div class="w-full md:w-1/3 md:justify-center text-center md:mt-[-100px]">
                @include('components.image', [
                   'image_id' => $ctaImage,
                   'size' => 'full',
                   'object_fit' => 'cover',
                   'img_class' => 'w-full object-cover',
                   'alt' => $alt,
               ])
            </div>
        @endif
    </div>
    <div>
        @if ($ctaForm)
            <div class="w-full mt-10">
                {!! gravity_form($ctaForm, false) ; !!}
            </div>
        @endif
    </div>
</div>