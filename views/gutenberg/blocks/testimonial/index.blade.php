@php
    // Content
    $title = $block['data']['title'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';

        $titlePosition = $block['data']['title_position'] ?? '';
        $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $titleClass = $titleClassMap[$titlePosition] ?? '';

    $textColor = $block['data']['text_color'] ?? '';


    // Testimonial
    $displayType = $block['data']['display_type'];
    $currentTerms = isset($_GET['testimonial_category']) ? array_map('intval', explode(',', $_GET['testimonial_category'])) : [];
    $multipleFilters = $block['data']['multiple_filters_enabled'] ?? false;

     // Show all
     if ($displayType == 'show_all') {
          $args = [
             'posts_per_page' => -1,
             'post_type' => 'testimonials',
             'post_status' => 'publish',
         ];

         if ($currentTerms) {
             $args['tax_query'] = [
                 [
                     'taxonomy' => 'testimonial_categories',
                     'field' => 'id',
                     'terms' => $currentTerms,
                 ],
             ];
         }

         $query = new WP_Query($args);
         $testimonials = wp_list_pluck($query->posts, 'ID');
     }

     // Show category
     elseif ($displayType == 'show_category') {
         $selectedCategory = $block['data']['category'] ?? '';

         $args = [
             'posts_per_page' => -1,
             'post_type' => 'testimonials',
             'post_status' => 'publish',
             'tax_query' => [
                 [
                     'taxonomy' => 'testimonial_categories',
                     'field' => 'id',
                     'terms' => $selectedCategory,
                 ],
             ],
         ];

         if ($currentTerms) {
             $args['tax_query'][] = [
                 'taxonomy' => 'testimonial_categories',
                 'field' => 'id',
                 'terms' => $currentTerms,
             ];
             $args['tax_query']['relation'] = 'AND';
         }

         $query = new WP_Query($args);
         $testimonials = wp_list_pluck($query->posts, 'ID');
     }

    // Show specific
    elseif ($displayType == 'show_specific') {
         $testimonials = $block['data']['show_specific_testimonials'];
         if (!is_array($testimonials) || empty($testimonials)) {
             $testimonials = [];
         }

         $args = [
             'posts_per_page' => -1,
             'post_type' => 'testimonials',
             'post_status' => 'publish',
             'tax_query' => [],
         ];

         if ($currentTerms) {
             $args['tax_query'][] = [
                 'taxonomy' => 'testimonial_categories',
                 'field' => 'id',
                 'terms' => $currentTerms,
             ];
             $args['tax_query']['relation'] = 'AND';
         }

         if (!empty($testimonials)) {
             $args['post__in'] = $testimonials;
         }

         $query = new WP_Query($args);
         $testimonials = wp_list_pluck($query->posts, 'ID');

//         todo: add filter for show latest
    }

    $visibleElements = $block['data']['show_element'] ?? [];


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';


    // Paddings & margins
    $randomNumber = rand(0, 1000);

    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';
@endphp

<section id="testimonial" class="block-testimonial relative testimonial-{{ $randomNumber }}-custom-padding testimonial-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $titleColor }} {{ $titleClass }}">{!! $subTitle !!}</span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @if (!empty($visibleElements) && in_array('category_filter', $visibleElements))
                @include('components.testimonials.category-filter')
            @endif
            @if ($testimonials)
                @include('components.testimonials.list', ['testimonials' => $testimonials])
            @endif

            {{-- todo: add button underneath--}}
        </div>
    </div>
</section>

<style>
    .testimonial-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif
            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif
            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif
            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif
            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif
            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif
            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif
            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif
            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif
            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif
        }
    }

    .testimonial-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif
            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif
            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif
            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif
            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif
            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif
            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif
            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif
            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif
            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif
        }
    }
</style>