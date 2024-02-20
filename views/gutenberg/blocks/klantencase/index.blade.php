@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    $caseQuoteColor = $block['data']['case_quote_color'] ?? '';
    $caseTextColor = $block['data']['case_text_color'] ?? '';
    $caseBackgroundColor = $block['data']['case_background_color'] ?? '';

    $layoutVersion = $block['data']['version'] ?? 'featured_layout';

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $buttonCardText = $block['data']['card_button_button_text'] ?? '';
    $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
    $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';

    // Show klantencases
    $displayType = $block['data']['display_type'];

    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'klantcases',
        ];

        $query = new WP_Query($args);
        $cases = wp_list_pluck($query->posts, 'ID');
    }
    elseif ($displayType == 'show_category') {
        $selectedCategory = $block['data']['category'] ?? '';
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'klantcases',
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $selectedCategory,
                ],
            ],
        ];
        $query = new WP_Query($args);
        $cases = wp_list_pluck($query->posts, 'ID');
    }
    elseif ($displayType == 'show_specific') {
        $cases = $block['data']['show_specific_case'];
            if (!is_array($cases) || empty($cases)) {
                $cases = [];
            }
    }
    elseif ($displayType == 'show_latest') {
        $postAmount = $block['data']['post_amount'] ?? 3;
        $args = [
            'posts_per_page' => $postAmount,
            'post_type' => 'klantcases',
            'orderby' => 'date',
            'order' => 'DESC',
        ];
        $query = new WP_Query($args);
        $cases = wp_list_pluck($query->posts, 'ID');
    }

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

@if ($cases)
    <section id="klantencases" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
             style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
            <div class="custom-styling {{ $blockClass }} mx-auto">
                @if ($title)
                    <h2 class="text-{{ $titleColor }} container mx-auto lg:mb-4 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
                @endif
                @if ($cases)
                    @include('components.cases.list', ['cases' => $cases])
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="w-full text-center mt-4 md:mt-8">
                        @include('components.buttons.default', [
                           'text' => $button1Text,
                           'href' => $button1Link,
                           'alt' => $button1Text,
                           'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                           'class' => 'rounded-lg text-left',
                           'target' => $button1Target,
                       ])
                    </div>
                @endif
            </div>
        </div>
    </section>
@endif
