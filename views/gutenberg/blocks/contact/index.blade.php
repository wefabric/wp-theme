@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $form = $block['data']['form'] ?? '';
    $formBackgroundColor = $block['data']['form_background_color'] ?? '';
    $visibleElements = $block['data']['show_element'] ?? [];

    // Show establishments
    $establishment_args = [
        'post_type' => 'establishments',
        'posts_per_page' => -1,
    ];
    $establishment_query = new WP_Query($establishment_args);

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme Settings
    $options = get_fields('option');
    $roundedDesign = $options['rounded_design'] ?? false;
    $borderRadius = $roundedDesign ? ($options['border_radius_strength'] ?? '') : 'rounded-none';
@endphp

<section id="contact" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto flex flex-col lg:flex-row gap-8">
            <div class="content-block w-full lg:w-1/3 xl:w-1/2 order-1 lg:order-0 px-8">
                @if ($title)
                    <h2 class="mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                @if (!empty($visibleElements) && in_array('establishments', $visibleElements) && $establishment_query->have_posts())
                    @while ($establishment_query->have_posts())
                        @php
                            $establishment_query->the_post();
                            $establishment_title = get_the_title();
                            $establishment_id = get_the_ID();
                            $street = get_post_meta($establishment_id, 'street', true);
                            $zipcode = get_post_meta($establishment_id, 'postcode', true);
                            $house_number = get_post_meta($establishment_id, 'house_number', true);
                            $house_number_addition = get_post_meta($establishment_id, 'house_number_addition', true);
                            $city = get_post_meta($establishment_id, 'city', true);
                        @endphp
                        <div class="mb-4 text-{{ $textColor }}">
                            <p class="font-bold">{{ $establishment_title }}</p>
                            @if($street && $house_number)
                                <p>{{ $street }} {{ $house_number }} {{ $house_number_addition }}</p>
                            @endif
                            @if($zipcode && $city)
                                <p>{{ $zipcode }}, {{ $city }}</p>
                            @endif
                            @if($street)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $street }}+{{ $house_number }}{{ $house_number_addition }}+{{ $zipcode }}+{{ $city }}"
                                   target="_blank" class="hover:text-primary underline">Routebeschrijving ></a>
                            @endif
                        </div>
                    @endwhile
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-' . $textColor])
                @endif
            </div>
            @if ($form)
                <div class="w-full lg:w-2/3 xl:w-1/2 order-0 lg:order-1 sm:px-8">
                    <div class="contact-block bg-{{ $formBackgroundColor }} p-12 lg:shadow-xl rounded-{{ $borderRadius }}">
                        {!! gravity_form($form) !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>