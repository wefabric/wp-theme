@php
    $title = $block['data']['title'];
    $subTitle = $block['data']['subtitle'];
    $imageId = $block['data']['background_image'];
    $textColor = $block['data']['text_color'];

     $textPosition = $block['data']['text_position'] ?? '';
     $textPositionClass = '';
     $textWidthClass = '';

    if ($textPosition === 'left') {
        $textPositionClass = 'justify-start text-left';
        $textWidthClass = 'w-full md:w-1/2 xl:w-1/3';
    } elseif ($textPosition === 'center') {
        $textPositionClass = 'justify-center text-center';
           $textWidthClass = 'w-full xl:w-3/4';
    } elseif ($textPosition === 'right') {
        $textPositionClass = 'justify-end text-left';
           $textWidthClass = 'w-full md:w-1/2 xl:w-1/3';
    }
@endphp

<section id="header-block" class="relative">
    <div class="bg-cover bg-center h-[400px] sm:h-[500px] md:h-[600px] lg:h-[600px] xl:h-[800px]" style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}') ">
        <div class="container mx-auto px-8 h-full flex items-center {{ $textPositionClass }}">
            <div class="text-shadow-lg text-{{ $textColor }} {{ $textWidthClass }}">
                <h1 class="mb-4">{{ $title }}</h1>
                <p class="text-lg mb-4 ">{{ $subTitle }}</p>
                <a class="btn bg-primary" href="">Aanmelden</a>
            </div>
        </div>
    </div>
</section>