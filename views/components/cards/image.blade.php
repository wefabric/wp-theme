@php
    $height = 'h-['. config('wp-support.image_sizes.'. $img_size .'.height') .'px]';
@endphp

<div class="{{ $height }} {{ $card_classes ?? '' }} flex flex-col items-center justify-center relative bg-center bg-cover bg-no-repeat"
    style="background-image: url('{{ wp_get_attachment_image_url($item->get('image'), $img_size) }}')">

    <div class="font-bold text-3xl">
        {{ $item->get('title') }}
    </div>

    <div class="absolute bottom-5 lg:right-5">
        @include('components.buttons.default', [
            'button' => $item,
            'colors' => 'btn-primary-light hover:btn-primary-dark text-white disable-chevron',
        ])
    </div>

</div>
