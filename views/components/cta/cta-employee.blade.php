@php
    $employee = get_fields($ctaEmployee);
    $employeeImageId = $employee['image'] ?? '';
    $employeeImage = $employeeImageId ? wp_get_attachment_image_url($employeeImageId, 'full') : '';
    $employeeTitle = $employee ? get_the_title($block['data']['employee']) : '';
@endphp

<div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
    <div class="w-full md:w-2/3 text-center mx-auto @if($employeeImage) mt-16 md:mt-32 @endif">
        @if ($title)
            <h2 class="text-{{ $titleColor }}">{{ $title }}</h2>
        @endif
        @if ($text)
            <p class="mt-4 md:mt-4 text-{{ $textColor }}">{{ $text }}</p>
        @endif
        @if (($button1Text) && ($button1Link))
            <div class="flex gap-4 w-full justify-center mt-4 md:mt-8">
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