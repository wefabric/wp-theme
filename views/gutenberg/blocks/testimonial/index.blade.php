@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $testimonialBackground = $block['data']['testimonial_background_color'] ?? 'none';

    // Show testimonial
    $selectedTestimonialFields = get_fields($block['data']['testimonial'] ?? '');
    $testimonialTitle = $selectedTestimonialFields ? get_the_title($block['data']['testimonial']) : '';
    $testimonialText = $selectedTestimonialFields['review'] ?? '';
    $testimonialFunction = $selectedTestimonialFields['function'] ?? '';
    $testimonialAvatarID = $selectedTestimonialFields['avatar'] ?? '';
    $testimonialImageID = $selectedTestimonialFields['image'] ?? '';

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

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="testimonial" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 md:px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto mb-4 px-8 md:px-0 {{ $titleClass }}">{{ $title }}</h2>
            @endif

            <div class="w-full text-{{ $textColor }}">
                <div class="relative flex items-center text-center md:text-left justify-center md:justify-start h-full min-h-full bg-{{ $testimonialBackground }} rounded-{{ $borderRadius }}">
                    <div class="w-full md:w-3/5 p-8 lg:p-16">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                             class="block mx-auto md:mx-0 w-8 h-8 mb-4"
                             viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                        </svg>
                        <p class="mb-6">{{ $testimonialText }}</p>
                        <div class="flex flex-col md:flex-row items-center gap-x-4 md:gap-x-6 gap-y-4">
                            @if ($testimonialAvatarID)
                                <div class="">
                                    @include('components.image', [
                                        'image_id' => $testimonialAvatarID,
                                        'size' => 'full',
                                        'object_fit' => 'cover',
                                        'img_class' => 'w-24 h-24 aspect-square rounded-full object-cover object-center',
                                        'alt' => $testimonialTitle,
                                    ])
                                </div>
                            @endif
                            <div>
                                @if ($testimonialTitle)
                                    <p class="font-bold text-lg">{{ $testimonialTitle }}</p>
                                    <p class="">{{ $testimonialFunction }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if ($testimonialImageID)
                        <div class="hidden md:block absolute bottom-0 right-0 w-2/5 h-full">
                            @include('components.image', [
                                'image_id' => $testimonialImageID,
                                'size' => 'full',
                                'object_fit' => 'cover',
                                'img_class' => 'w-full h-full aspect-square object-cover rounded-' . $borderRadius,
                                'alt' => $testimonialTitle,
                            ])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>