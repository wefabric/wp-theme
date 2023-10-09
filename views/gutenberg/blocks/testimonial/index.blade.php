@php
    // Content
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';

    $titleColor = $block['data']['title_color'] ?? '';

    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="testimonial" class="relative py-16 lg:py-0 bg-{{ $backgroundColor}}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{$overlayColor}} opacity-{{$overlayOpacity}}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }} text-{{ $titleColor }}">
        <div class="{{ $blockClass }} mx-auto">
            <h2 class="mb-4 {{ $titleClass }}">{{ $title }}</h2>

        </div>
    </div>
</section>


{{--<section id="testimonial-block" class="relative">--}}
{{--    <div class="container mx-auto px-8 lg:py-20">--}}
{{--        <h2 class="w-full lg:w-2/3 mx-auto mb-20">Testimonial</h2>--}}

{{--        <div class="w-2/3 mx-auto">--}}
{{--            <div class="w-full">--}}
{{--                <div class="h-full bg-gray-100 p-8 rounded">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="block w-6 h-6 text-gray-400 mb-4" viewBox="0 0 975.036 975.036">--}}
{{--                        <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>--}}
{{--                    </svg>--}}
{{--                    <p class="leading-relaxed mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad.</p>--}}
{{--                    <a class="inline-flex items-center">--}}
{{--                        <img alt="testimonial" src="https://dummyimage.com/106x106" class="w-12 h-12 rounded-full flex-shrink-0 object-cover object-center">--}}
{{--                        <span class="flex-grow flex flex-col pl-4">--}}
{{--                            <span class="title-font font-medium"><?php the_field('author'); ?></span>--}}
{{--                            <span class="text-gray-500 text-sm">Front-end Developer</span>--}}
{{--                        </span>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</section>--}}
