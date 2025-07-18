@php
    //    todo: Needs block update
    // todo: Kijken of deze vervangen kan worden door kaartenblok

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
        $buttonCardText = $block['data']['card_button_button_text'] ?? '';
        $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
        $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';


    // Show technologies
    $technoloyTitleColor = $block['data']['technology_title_color'] ?? '';
    $technologyTextColor = $block['data']['technology_text_color'] ?? '';
    $technologyLayout = $block['data']['technology_layout'] ?? 'horizontal';


    $displayType = $block['data']['display_type'];

    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'technologies',
            'post_status' => 'publish',
        ];

          // Exclude current post
        if(get_post()->post_type == 'technologies') {
            $args['post__not_in'] = [get_post()->ID];
        }

        $query = new WP_Query($args);
        $technologies = wp_list_pluck($query->posts, 'ID');
    }
    elseif ($displayType == 'show_category') {
        $selectedCategory = $block['data']['category'] ?? '';
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'technologies',
            'post_status' => 'publish',
            'tax_query' => [
                [
                    'taxonomy' => 'technology_categories',
                    'field' => 'id',
                    'terms' => $selectedCategory,
                ],
            ],
        ];

         // Exclude current post
        if(get_post()->post_type == 'technologies') {
            $args['post__not_in'] = [get_post()->ID];
        }

        $query = new WP_Query($args);
        $technologies = wp_list_pluck($query->posts, 'ID');
    }
    elseif ($displayType == 'show_specific') {
        $technologies = $block['data']['show_specific_technologies'];
            if (!is_array($technologies) || empty($technologies)) {
                $technologies = [];
            }
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

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'technologies' }}@endif" class="block-technologies relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto lg:mb-4 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @if ($technologies)
                @include('components.technologies.list', ['technologies' => $technologies])
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