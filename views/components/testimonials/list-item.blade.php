@php
    $fields = get_fields($testimonial);

    $testimonialBackground = $block['data']['testimonial_background_color'] ?? 'none';
    $testimonialTextColor = $block['data']['testimonial_text_color'] ?? '';

    $testimonialTitle = get_the_title($testimonial) ?? '';
    $testimonialUrl = get_permalink($testimonial);
    $testimonialCustomUrl = $fields['link'] ?? '';
    $testimonialName = $fields['name'] ?? '';
    $testimonialText = $fields['testimonial_text'] ?? '';
    $testimonialFunction = $fields['function'] ?? '';
    $testimonialAvatarId = $fields['avatar'] ?? '';
    $testimonialLogoId = $fields['logo_image'] ?? '';
    $testimonialImageId = $fields['image'] ?? '';
    $testimonialStars = $fields['star_rating'] ?? '';

    $testimonialLink = $block['data']['testimonial_link'] ?? 'testimonial_link';
    $imagePosition = $block['data']['image_position'] ?? 'right';

    $visibleElements = $block['data']['show_element'] ?? [];
    $testimonialCategories = get_the_terms($testimonial, 'testimonial_categories');
@endphp

<div class="testimonial-item custom-styling flex w-full h-full text-{{ $testimonialTextColor }} @if ($flyinEffect) testimonial-hidden @endif">

    <div class="testimonial-block relative w-full h-auto flex flex-col md:flex-row bg-{{ $testimonialBackground }} rounded-{{ $borderRadius }}">

        @if (!empty($visibleElements) && in_array('category', $visibleElements))
            <div class="testimonial-categories absolute z-20 top-[15px] @if($imagePosition == 'right') image-right right-[15px] @else image-left left-[15px] @endif flex flex-wrap gap-2">
                @foreach ($testimonialCategories as $category)
                    @php
                        $categoryColor = get_field('category_color', $category);
                        $categoryIcon = get_field('category_icon', $category);
                        $categoryImage = get_field('category_image', $category);
                    @endphp
                    <div style="background-color: {{ $categoryColor }}"
                         class="testimonial-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                        @if($categoryImage)
                            <img src="{{ wp_get_attachment_image_url($categoryImage, 'thumbnail') }}" alt="{{ $category->name }}" class="w-5 h-5 object-contain">
                        @endif
                        {!! $categoryIcon !!} <span>{!! $category->name !!}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="content-section flex flex-col items-center md:items-start w-full h-full p-8 lg:p-16 @if($imagePosition == 'right') order-2 md:order-1 @else order-2 @endif">

            @if (!empty($visibleElements) && in_array('quote', $visibleElements))
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="quote-icon block w-8 h-8 mb-2 md:mb-6 order-3 md:order-1"
                     viewBox="0 0 975.036 975.036">
                    <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                </svg>
            @endif

            @if (!empty($visibleElements) && in_array('star_rating', $visibleElements) && $testimonialStars)
                <div class="star-rating flex items-center mb-4 text-[24px] order-2">
                    @php
                        $fullStars = floor($testimonialStars);
                        $hasHalfStar = $testimonialStars - $fullStars >= 0.5;
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $fullStars)
                            <i class="fas fa-star text-yellow-500"></i>
                        @elseif ($i == $fullStars + 1 && $hasHalfStar)
                            <i class="fas fa-star-half-alt text-yellow-500"></i>
                        @else
                            <i class="far fa-star text-yellow-500"></i>
                        @endif
                    @endfor
                </div>
            @endif

            @if (!empty($visibleElements) && in_array('testimonial_text', $visibleElements) && $testimonialText)
                @include('components.content', ['content' => apply_filters('the_content', $testimonialText), 'class' => 'testimonial-text md:mb-6 order-4 md:order-3'])
            @endif

            <div class="avatar-section flex flex-col md:flex-row items-center gap-x-4 md:gap-x-6 gap-y-4 mb-4 md:mb-0 order-1 md:order-4 text-center md:text-left">
                @if (!empty($visibleElements) && in_array('avatar_image', $visibleElements) && $testimonialAvatarId)
                    <div class="avatar-image-section">
                        @include('components.image', [
                            'image_id' => $testimonialAvatarId,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'avatar-image w-24 h-24 aspect-square rounded-full object-cover object-center',
                            'alt' => $testimonialTitle,
                        ])
                    </div>
                @endif
                @if ($testimonialName || $testimonialFunction)
                    <div class="avatar-details">
                        @if (!empty($visibleElements) && in_array('name', $visibleElements) && $testimonialName)
                            <div class="name-text font-bold text-lg">{!! $testimonialName !!}</div>
                        @endif
                        @if (!empty($visibleElements) && in_array('function', $visibleElements) && $testimonialFunction)
                            <div class="function-text">{!! $testimonialFunction !!}</div>
                        @endif
                    </div>
                @endif
                @if (!empty($visibleElements) && in_array('logo_image', $visibleElements) && $testimonialLogoId)
                    <div class="logo-image-section flex-1">
                        @include('components.image', [
                            'image_id' => $testimonialLogoId,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'logo-image object-contain object-center',
                            'alt' => $testimonialTitle,
                        ])
                    </div>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @php
                    $buttonUrl = '';
                    if ($testimonialLink === 'testimonial_link') {
                        $buttonUrl = $testimonialUrl;
                    } elseif ($testimonialLink === 'custom_link' && !empty($testimonialCustomUrl)) {
                        $buttonUrl = $testimonialCustomUrl;
                    }
                @endphp

                @if ($buttonCardText && $buttonUrl)
                    <div class="testimonial-button mt-auto pt-8 z-10 order-5">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $buttonUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                           'icon' => $buttonCardIcon,
                        ])
                    </div>
                @endif
            @endif


        </div>

        @if ($testimonialImageId)
            <div class="testimonial-image w-full md:w-2/5 h-auto flex-grow @if($imagePosition == 'right') order-1 md:order-2 @else order-1 @endif">
                @include('components.image', [
                    'image_id' => $testimonialImageId,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'h-full max-h-[200px] md:max-h-fit w-full aspect-square object-cover rounded-' . $borderRadius,
                    'alt' => $testimonialTitle,
                ])
            </div>
        @endif

    </div>
</div>