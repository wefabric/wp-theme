@php
    //    todo: Needs block update

    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    $newsTitleColor = $block['data']['news_title_color'] ?? '';
    $newsTextColor = $block['data']['news_text_color'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $buttonCardText = $block['data']['card_button_button_text'] ?? '';
        $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
        $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';


    // Nieuws en activiteit
    $displayType = $block['data']['display_type'];

    // Show all
    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'post',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    // Show category
    elseif ($displayType == 'show_category') {
        $selectedCategory = $block['data']['category'] ?? '';
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'post',
            'tax_query' => [
                [
                    'taxonomy' => 'category',
                    'field' => 'id',
                    'terms' => $selectedCategory,
                ],
            ],
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    // Show specific
    elseif ($displayType == 'show_specific') {
        $posts = $block['data']['show_specific_news'];
        if (!is_array($posts) || empty($posts)) {
            $posts = [];
        }
    }

    // Show latest
    elseif ($displayType == 'show_latest') {
        $postAmount = $block['data']['post_amount'] ?? 3;
        $args = [
            'posts_per_page' => $postAmount,
            'post_type' => 'post',
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'post') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
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
    $customBlockId = $block['data']['custom_block_id'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'nieuws-activiteit' }}@endif" class="block-nieuws-activiteit relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto lg:mb-4 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @if (!empty($block['data']['show_element']) && in_array('category_filter', $block['data']['show_element']))
                <div class="mt-6">
                    @include('components.news.category-list')
                </div>
            @endif
            @if($posts)
                @include('components.news-activity.list', ['posts' => $posts])
            @endif
            @if (($button1Text) && ($button1Link))
                <div class="bottom-button w-full text-center mt-4 md:mt-8">
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