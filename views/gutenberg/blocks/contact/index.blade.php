@php
    //    todo: Needs block update

    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $contentBackgroundColor = $block['data']['content_background_color'] ?? '';
    $visibleElements = $block['data']['show_element'] ?? [];


    // Formulier
    $form = $block['data']['form'] ?? '';
    $formBackgroundColor = $block['data']['form_background_color'] ?? '';
    $formTitle = $block['data']['form_title'] ?? '';
    $formTitleColor = $block['data']['form_title_color'] ?? '';
    $formPosition = $block['data']['form_position'] ?? 'right';


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
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
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


    // Theme Settings
    $options = get_fields('option');
    $roundedDesign = $options['rounded_design'] ?? false;
    $borderRadius = $roundedDesign ? ($options['border_radius_strength'] ?? '') : 'rounded-none';
@endphp

<section id="contact" class="block-contact contact-{{ $randomNumber }}-custom-padding contact-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="custom-layout {{ $blockClass }} mx-auto flex flex-col lg:flex-row gap-2 lg:gap-8">
            <div class="content-block w-full lg:w-2/5 order-1 @if ($formPosition == 'right') lg:order-0 @else lg:order-1 @endif py-8 px-8 lg:py-12 bg-{{ $contentBackgroundColor }}">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }}">{!! $subTitle !!}</span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                <div class="flex flex-col">
                    @if (!empty($visibleElements) && in_array('establishments', $visibleElements) && $establishment_query->have_posts())
                        <div class="establishment-list">
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
                                    $phone = get_post_meta($establishment_id, 'common_phone', true);
                                    $email = get_post_meta($establishment_id, 'common_email', true);
                                    $country_id = get_post_meta($establishment_id, 'country_id', true);
                                    if($country_id) {
                                        $countryNames = [
                                            'NL' => 'The Netherlands',
                                            'BR' => 'Brazil',
                                        ];
                                        $countryName = isset($countryNames[$country_id]) ? $countryNames[$country_id] : $country_id;
                                    }
                                @endphp
                                <div class="establishment mb-4 text-{{ $textColor }}">
                                    <div class="establishment-title font-bold">{{ $establishment_title }}</div>
                                    @if ($street && $house_number)
                                        <div class="establishment-street">{{ $street }} {{ $house_number }} {{ $house_number_addition }}</div>
                                    @endif
                                    @if ($zipcode && $city)
                                        <div class="establishment-zipcode">{{ $zipcode }}, {{ $city }}</div>
                                    @endif
{{--                                    @if ($countryName)--}}
{{--                                        <div class="establishment-country">{{ $countryName }}</div>--}}
{{--                                    @endif--}}
                                    @if($visibleElements && in_array('contact', $visibleElements))
                                        <div class="contact-info mt-8 flex flex-col gap-y-2">
                                            <div class="contact-text font-bold">Contact</div>
                                            @if($phone)
                                                <a class="phone-link group flex items-center gap-2 w-fit"
                                                   href="tel:{{ $phone['number'] }}"
                                                   title="Telefoonnummer">
                                                    <i class="fa-solid fa-phone text-primary group-hover:scale-110 duration-200 ease-in-out"></i>
                                                    <span class="align-middle group-hover:text-primary group-hover:underline">{{ $phone['number'] }}</span>
                                                </a>
                                            @endif
                                            @if($email)
                                                <a class="email-link group flex items-center gap-2 w-fit"
                                                   href="mailto:{{ $email }}"
                                                   title="Email">
                                                    <i class="fa-solid fa-envelope text-primary group-hover:scale-110 duration-200 ease-in-out"></i>
                                                    <span class="align-middle group-hover:text-primary group-hover:underline">{{ $email }}</span>
                                                </a>
                                            @endif
                                            @if($street && $visibleElements && in_array('route_description', $visibleElements))
                                                <div class="route-info">
                                                    <a class="route-link group flex items-center gap-2 w-fit"
                                                       href="https://www.google.com/maps/search/?api=1&query={{ $street }}+{{ $house_number }}{{ $house_number_addition }}+{{ $zipcode }}+{{ $city }}"
                                                       title="Email">
                                                        <i class="fa-solid fa-route text-primary group-hover:scale-110 duration-200 ease-in-out"></i>
                                                        <span class="align-middle group-hover:text-primary group-hover:underline">Route</span>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            @endwhile
                        </div>
                    @endif
                    @if ($text)
                        @include('components.content', [
                            'content' => apply_filters('the_content', $text),
                            'class' => 'mt-4 text-' . $textColor
                        ])
                    @endif
                </div>
            </div>
            @if ($form)
                <div class="form-block w-full lg:w-3/5 order-0 @if ($formPosition == 'right') lg:order-1 @else lg:order-0 @endif">
                    <div class="contact-block bg-{{ $formBackgroundColor }} p-8 lg:p-12 rounded-{{ $borderRadius }}">
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
    .contact-{{ $randomNumber }}-custom-padding {
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

    .contact-{{ $randomNumber }}-custom-margin {
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