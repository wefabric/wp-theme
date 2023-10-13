@php
    $employee = get_fields($ctaEmployee);
    $employeeImageId = $employee['image'] ?? '';
    $employeeImage = $employeeImageId ? wp_get_attachment_image_url($employeeImageId, 'full') : '';
    $employeeTitle = $employee ? get_the_title($block['data']['employee']) : '';
@endphp

<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="w-full md:w-2/3 text-center mx-auto mt-16 md:mt-32">
        @if ($title)
            <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
        @endif
        @if (!empty($text))
            <p class="mt-4 md:mt-4 text-{{$textColor}}">{{ $text }}</p>
        @endif

        @if (!empty($buttonText) && !empty($buttonLink))
            <div class="w-full md:w-1/3 md:justify-center text-center mx-auto mt-2">
                <a href="{{ $buttonLink }}"
                   class="btn button-secondary bg-secondary-color hover:bg-secondary-dark text-base">{{ $buttonText }}</a>
            </div>
        @endif
    </div>
</div>