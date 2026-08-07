@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $subtitleIcon = $block['data']['subtitle_icon'] ?? '';
    $subtitleIcon = $subtitleIcon ? json_decode($subtitleIcon, true) : null;
    $subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $imageId = $block['data']['image'] ?? '';
    $imageAlt = get_post_meta($imageId, '_wp_attachment_image_alt', true);

    // Contactgegevens: automatisch vanuit een vestiging, of handmatig ingevuld
    $showFromEstablishment = $block['data']['show_from_establishment'] ?? false;
    $phoneHref = '';
    $phoneText = '';
    $email = '';
    $whatsappNumber = '';

    if ($showFromEstablishment) {
        $establishmentId = $block['data']['establishment'] ?? '';

        if (!$establishmentId) {
            $establishmentQuery = new WP_Query([
                'post_type'      => 'establishments',
                'posts_per_page' => 1,
                'post_status'    => 'publish',
                'orderby'        => 'menu_order',
                'order'          => 'ASC',
            ]);
            $establishmentId = $establishmentQuery->posts[0]->ID ?? '';
        }

        if ($establishmentId) {
            $establishment = new \Wefabric\WPEstablishments\Establishment($establishmentId);
            if ($phoneObject = $establishment->getContactPhone()) {
                $phoneHref = $phoneObject->uri();
                $phoneText = get_bloginfo('language') === 'nl-NL' ? $phoneObject->national() : $phoneObject->international();
            }
            $email = $establishment->getEmailAddress();
            $whatsappNumber = $establishment->whatsapp_number ?? '';
        }
    } else {
        $phoneText = $block['data']['phone'] ?? '';
        $phoneHref = $phoneText ? 'tel:' . preg_replace('/[^0-9+]/', '', $phoneText) : '';
        $email = $block['data']['email'] ?? '';
        $whatsappNumber = $block['data']['whatsapp_number'] ?? '';
    }

    $contentBackgroundColor = $block['data']['content_background_color'] ?? '';


    // Formulier
    $form = $block['data']['form'] ?? '';
    $formBackgroundColor = $block['data']['form_background_color'] ?? '';
    $formTitle = $block['data']['form_title'] ?? '';
    $formTitleColor = $block['data']['form_title_color'] ?? '';
    $formPosition = $block['data']['form_position'] ?? 'right';
    $formSize = $block['data']['form_size'] ?? '50';
    $verticalCentered = $block['data']['vertical_centered'] ?? false;

    $sizes = [
        '33' => ['lg:w-1/3', 'lg:w-2/3'],
        '40' => ['lg:w-2/5', 'lg:w-3/5'],
        '50' => ['lg:w-1/2', 'lg:w-1/2'],
        '60' => ['lg:w-3/5', 'lg:w-2/5'],
        '66' => ['lg:w-2/3', 'lg:w-1/3'],
    ];

    [$formClass, $contentClass] = $sizes[$formSize] ?? ['lg:w-1/2', 'lg:w-1/2'];


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
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


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


    // Theme settings
    $options = get_fields('option');
    $roundedDesign = $options['rounded_design'] ?? false;
    $borderRadius = $roundedDesign ? ($options['border_radius_strength'] ?? '') : 'rounded-none';
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'tekst-formulier' }}@endif"
         class="block-tekst-formulier tekst-formulier-{{ $randomNumber }}-custom-padding tekst-formulier-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="custom-layout {{ $blockClass }} mx-auto flex flex-col lg:flex-row gap-2 lg:gap-8 @if ($verticalCentered) lg:items-center @endif">
            <div class="content-block h-fit w-full {{ $contentClass }} order-1 @if ($formPosition == 'right') lg:order-0 @else lg:order-1 @endif py-8 px-8 lg:py-12 bg-{{ $contentBackgroundColor }}">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }}">
                        @if ($subtitleIcon)
                            <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                        @endif
                        {!! $subTitle !!}
                    </span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                        'content' => apply_filters('the_content', $text),
                        'class' => 'mb-6 text-' . $textColor,
                    ])
                @endif
                @if ($phoneText || $email || $whatsappNumber)
                    <div class="contact-layout flex flex-col gap-y-2 text-{{ $textColor }} @if ($imageId) mb-6 @endif">
                        @if ($phoneText)
                            <a class="phone-link group flex items-center gap-2 w-fit"
                               href="{{ $phoneHref }}"
                               title="Telefoonnummer">
                                <i class="fa-solid fa-phone text-primary"></i>
                                <span class="align-middle group-hover:text-primary group-hover:underline">{{ $phoneText }}</span>
                            </a>
                        @endif

                        @if ($email)
                            <a class="email-link group flex items-center gap-2 w-fit"
                               href="mailto:{{ $email }}"
                               title="Email">
                                <i class="fa-solid fa-envelope text-primary"></i>
                                <span class="align-middle group-hover:text-primary group-hover:underline">{{ $email }}</span>
                            </a>
                        @endif

                        @if ($whatsappNumber)
                            <a class="whatsapp-link group flex items-center gap-2 w-fit"
                               href="https://wa.me/{{ preg_replace('/\D+/', '', $whatsappNumber) }}"
                               target="_blank" rel="noopener"
                               title="Whatsapp">
                                <i class="fa-brands fa-whatsapp text-primary"></i>
                                <span class="align-middle group-hover:text-primary group-hover:underline">{{ $whatsappNumber }}</span>
                            </a>
                        @endif
                    </div>
                @endif
                @if ($imageId)
                    @include('components.image', [
                        'image_id' => $imageId,
                        'size' => 'full',
                        'object_fit' => 'cover',
                        'class' => 'block',
                        'img_class' => 'w-full rounded-' . $borderRadius,
                        'alt' => $imageAlt,
                    ])
                @endif
            </div>

            @if ($form)
                <div class="form-block w-full {{ $formClass }} order-0 @if ($formPosition == 'right') lg:order-1 @else lg:order-0 @endif">
                    <div class="form-container bg-{{ $formBackgroundColor }} p-8 lg:p-12 rounded-{{ $borderRadius }}">
                        <div class="form h-full w-full">
                            @if ($formTitle)
                                <h2 class="form-title mb-4 text-{{ $formTitleColor }}">{!! $formTitle !!}</h2>
                            @endif
                            {!! gravity_form($form, false) !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<style>
    .tekst-formulier-{{ $randomNumber }}-custom-padding {
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

    .tekst-formulier-{{ $randomNumber }}-custom-margin {
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
