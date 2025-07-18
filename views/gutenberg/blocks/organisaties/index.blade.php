@php
    //    todo: Needs block update

    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';


    // Organisations
    $displayType = $block['data']['display_type'];

    $organisationBackgroundColor = $block['data']['organisation_background_color'] ?? '';
    $organisationTitleColor = $block['data']['organisation_title_color'] ?? '';
    $organisationTextColor = $block['data']['organisation_text_color'] ?? '';


    // Show all
    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'organisation',
            'post_status' => 'publish',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'organisation') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $organisations = wp_list_pluck($query->posts, 'ID');
    }

    // Show category
    elseif ($displayType == 'show_category') {
        $selectedCategory = $block['data']['category'] ?? '';
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'organisation',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'organisation_categories',
                    'field' => 'id',
                    'terms' => $selectedCategory,
                ],
            ],
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'organisation') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $organisations = wp_list_pluck($query->posts, 'ID');
    }

    // Show specific
    elseif ($displayType == 'show_specific') {
        $organisations = $block['data']['show_specific_organisations'];
         if (!is_array($organisations) || empty($organisations)) {
            $organisations = [];
        } else {
            $organisations = array_filter($organisations, function ($postID) {
                return get_post_status($postID) === 'publish';
            });
        }
    }

    // Show latest
    elseif ($displayType == 'show_latest') {
        $postAmount = $block['data']['post_amount'] ?? 3;
        $args = [
            'posts_per_page' => $postAmount,
            'post_type' => 'organisation',
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'organisation') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        $organisations = wp_list_pluck($query->posts, 'ID');
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

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'organisaties' }}@endif" class="block-organisaties relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto lg:mb-4 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @if ($organisations)
                @include('components.organisations.list', ['organisations' => $organisations])
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