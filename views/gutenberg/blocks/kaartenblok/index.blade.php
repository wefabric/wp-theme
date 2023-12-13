@php
    // Card block variant
   $cardVariant = $block['data']['cardblock_version'] ?? '';

   // Content
   $title = $block['data']['title'] ?? '';
   $titleColor = $block['data']['title_color'] ?? '';
   $titlePosition = $block['data']['title_position'] ?? '';
   $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
   $titleClass = $titleClassMap[$titlePosition] ?? '';

   // Buttons
   $button1Text = $block['data']['button_bottom_button_1']['title'] ?? '';
   $button1Link = $block['data']['button_bottom_button_1']['url'] ?? '';
   $button1Target = $block['data']['button_bottom_button_1']['target'] ?? '_self';
   $button1Color = $block['data']['button_bottom_button_1_color'] ?? '';
   $button1Style = $block['data']['button_bottom_button_1_style'] ?? '';
   $buttonCardText = $block['data']['card_button_button_text'] ?? '';
   $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
   $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';

   $cardBackgroundColor = $block['data']['card_background_color'] ?? '';
   $cardTitleColor = $block['data']['card_title_color'] ?? '';
   $cardTextColor = $block['data']['card_text_color'] ?? '';

   // Show pages
   $pagesData = [];
   $numPages = isset($block['data']['pages']) ? intval($block['data']['pages']) : 0;

   for ($i = 0; $i < $numPages; $i++) {
    $pageKey = "pages_{$i}_page";
    $pageId = $block['data'][$pageKey] ?? 0;
    $iconKey = "pages_{$i}_icon";
    $imageKey = "pages_{$i}_image";
    $imageId = $block['data'][$imageKey] ?? 0;

        if ($pageId) {
            $page = get_post($pageId);

            if ($page) {
                $icon = $block['data'][$iconKey] ?? '';

                $featured_image_id = 0;
                if ($imageId) {
                    $featured_image_id = $imageId;
                } elseif (has_post_thumbnail($page->ID)) {
                    $thumbnail_id = get_post_thumbnail_id($page->ID);
                    $featured_image_id = $thumbnail_id;
                }

                $pagesData[] = [
                    'id' => $page->ID,
                    'title' => $page->post_title,
                    'url' => get_permalink($page->ID),
                    'content' => $page->post_content,
                    'icon' => $icon,
                    'image_id' => $imageId,
                    'featured_image_id' => $featured_image_id,
                ];
            }
        }
    }

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

   // Theme settings
   $options = get_fields('option');
   $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';
@endphp

<section id="kaarten" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }} @if ($cardVariant == 'variant1') content-in-card @elseif ($cardVariant == 'variant2') content-under-card @endif"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="block-content {{ $blockClass }} mx-auto {{ $titleClass }}">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto lg:mb-12 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @include('components.cardblock.list')
            @if (($button1Text) && ($button1Link))
                <div class="w-full text-center mt-4 md:mt-8">
                    @include('components.buttons.default', [
                       'text' => $button1Text,
                       'href' => $button1Link,
                       'alt' => $button1Text,
                       'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                       'class' => 'rounded-lg',
                       'target' => $button1Target,
                   ])
                </div>
            @endif
        </div>
    </div>
</section>