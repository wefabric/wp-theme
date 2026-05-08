@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
        $textClass = $textClassMap[$textPosition] ?? 'text-left';

    $flexClassMap = ['left' => 'items-start', 'center' => 'items-center', 'right' => 'items-end',];
    $flexClass = $flexClassMap[$textPosition] ?? 'items-center';
    $ctaLayout = $block['data']['cta_layout'] ?? '';
    $flexDirection = ($ctaLayout === 'vertical') ? 'flex-col' : (($ctaLayout === 'horizontal') ? 'flex-row' : '');

    $ctaForm = $block['data']['form'] ?? '';
    $sideImage = $block['data']['side_image'] ?? '';
    $topImage = $block['data']['top_image'] ?? '';

    $blockBackgroundColor = $block['data']['block_background_color'] ?? '';
    $blockBackgroundImage = $block['data']['block_background_image'] ?? '';
    $blockOverlayEnabled = $block['data']['block_overlay_image'] ?? false;
    $blockOverlayColor = $block['data']['block_overlay_color'] ?? '';
    $blockOverlayOpacity = $block['data']['block_overlay_opacity'] ?? '';

    // Contact details
    $showContact = $block['data']['show_contact'] ?? false;
    $showSocials = $block['data']['show_socials'] ?? false;
    $establishmentElements = $block['data']['establishment_elements'] ?? [];
    $contactEstablishment = null;
    $contactAcfData = [];
    $contactOpeningHours = [];
    if ($showContact) {
        $selectedEstablishment = $block['data']['contact_establishment'] ?? null;
        if ($selectedEstablishment && is_object($selectedEstablishment)) {
            $contactEstablishment = new \Wefabric\WPEstablishments\Establishment($selectedEstablishment);
        } elseif ($selectedEstablishment && isset($selectedEstablishment->ID)) {
            $contactEstablishment = new \Wefabric\WPEstablishments\Establishment($selectedEstablishment);
        } else {
            $contactEstablishment = \Wefabric\WPEstablishments\Establishment::primary();
        }
        if ($contactEstablishment) {
            $contactAcfData = get_fields($contactEstablishment->post->ID) ?: [];
            $contactOpeningHours = $contactAcfData['opening_hours'] ?? [];
        }
    }
    $options = get_fields('option');
    $contactIconColor = $options['title_color'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $button1Download = $block['data']['button_button_1_download'] ?? false;
        $button1Icon = $block['data']['button_button_1_icon'] ?? '';
        if (!empty($button1Icon)) {
            $iconData = json_decode($button1Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }
        $button2Text = $block['data']['button_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_button_2_color'] ?? '';
        $button2Style = $block['data']['button_button_2_style'] ?? '';
        $button2Download = $block['data']['button_button_2_download'] ?? false;
        $button2Icon = $block['data']['button_button_2_icon'] ?? '';
        if (!empty($button2Icon)) {
            $iconData = json_decode($button2Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }


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


    // Theme settings
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

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'cta-contact' }}@endif" class="block-cta-contact relative cta-contact-{{ $randomNumber }}-custom-padding cta-contact-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="cta-custom {{ $fullScreenClass }} @if ($topImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
        {{--Voor het uitlijnen naar rechts--}}
        <div class="custom-width background-container absolute top-0 right-0 h-full @if ($topImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        @if ($topImage)
            <div class="top-image overlay absolute z-30 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @include('components.image', [
                    'image_id' => $topImage,
                    'size' => 'job-thumbnail',
                    'object_fit' => 'cover',
                    'img_class' => 'w-[200px] aspect-square object-cover rounded-full',
                    'alt' => get_post_meta($topImage, '_wp_attachment_image_alt', true) ?: 'Top image',
                ])
            </div>
        @endif

        <div class="cta-block relative z-10 mx-auto {{ $blockClass }} @if($blockWidth !== 'fullscreen') md:px-8 @endif">

            <div class="background relative px-8 py-16 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"
                 style="background-image: url('{{ wp_get_attachment_image_url($blockBackgroundImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($blockBackgroundImage) }}">
                @if ($blockOverlayEnabled)
                    <div class="cta-overlay absolute inset-0 bg-{{ $blockOverlayColor }} opacity-{{ $blockOverlayOpacity }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"></div>
                @endif

                <div class="cta-wrapper container mx-auto @if($blockWidth == 'fullscreen') px-8 @else w-full md:px-16 @endif relative z-10 @if($sideImage) flex flex-col xl:flex-row justify-between items-center gap-8 !px-0 xl:!px-16 @endif">

                    <div class="cta-data flex flex-col @if($sideImage) order-2 xl:order-1 w-full xl:w-1/2 flex-col @endif md:{{ $flexDirection }} {{ $flexClass }} justify-center gap-x-16 gap-y-4 @if($topImage) mt-16 md:mt-20 @endif">
                        <div class="cta-data-styling w-fit @if($ctaLayout == 'vertical' && $textPosition !== 'center') {{ $textClass }} @else text-center @endif md:{{ $textClass }}">
                            @if ($subTitle)
                                <span class="subtitle block mb-2 text-{{ $subTitleColor }}">{!! $subTitle !!}</span>
                            @endif
                            @if ($title)
                                <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                            @endif
                            @if ($text)
                                 @include('components.content', [
                                    'content' => apply_filters('the_content', $text),
                                    'class' => 'mt-4 text-' . $textColor,
                                 ])
                            @endif
                        </div>
                        @if (($button1Text) && ($button1Link))
                            <div class="buttons flex flex-wrap gap-y-2 gap-x-4 w-fit
                                {{ $textPosition === 'left' ? 'sm:justify-start' : '' }}
                                {{ $textPosition === 'center' ? 'sm:justify-center' : '' }}
                                {{ $textPosition === 'right' ? 'sm:justify-end' : '' }}
                            ">
                                @include('components.buttons.default', [
                                  'text' => $button1Text,
                                  'href' => $button1Link,
                                  'alt' => $button1Text,
                                  'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                                  'class' => 'rounded-lg',
                                  'target' => $button1Target,
                                  'icon' => $button1Icon,
                                  'download' => $button1Download,
                                ])
                                @if (($button2Text) && ($button2Link))
                                    @include('components.buttons.default', [
                                        'text' => $button2Text,
                                        'href' => $button2Link,
                                        'alt' => $button2Text,
                                        'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                        'class' => 'rounded-lg',
                                        'target' => $button2Target,
                                        'icon' => $button2Icon,
                                        'download' => $button2Download,
                                    ])
                                @endif
                            </div>
                        @endif

                        @if ($showContact && $contactEstablishment)
                            <div class="contact-details mt-6 flex flex-col gap-y-3">

                                {{-- Naam --}}
                                @if(in_array('establishment_name', $establishmentElements))
                                    <div class="establishment-name font-semibold">
                                        {{ $contactEstablishment->name }}
                                    </div>
                                @endif

                                {{-- Adres --}}
                                @if(in_array('establishment_address', $establishmentElements) || in_array('establishment_country', $establishmentElements))
                                    @php
                                        $addr = $contactEstablishment->getAddress();
                                        $contactCountryId = $addr->country_id ?? '';
                                        $contactCountryNames = ['NL' => 'Nederland'];
                                        $contactCountryName = $contactCountryNames[$contactCountryId] ?? $contactCountryId;
                                    @endphp
                                    <div class="establishment-address">
                                        @if($addr->street) {{ $addr->street }} @endif
                                        @if($addr->full_housenumber > 0) {{ $addr->full_housenumber }} @endif
                                        <br>
                                        @if($addr->postcode) {{ $addr->postcode }} @endif
                                        @if($addr->city) {{ $addr->city }} @endif
                                        @if(in_array('establishment_country', $establishmentElements) && $contactCountryName)
                                            <br>{{ $contactCountryName }}
                                        @endif
                                    </div>
                                @endif

                                {{-- Telefoon --}}
                                @if(in_array('establishment_phone', $establishmentElements) && $contactPhone = $contactEstablishment->getContactPhone())
                                    @include('components.link.opening', [
                                        'href' => $contactPhone->uri(),
                                        'alt' => 'Telefoonnummer',
                                        'class' => 'phone-text flex w-fit items-center'
                                    ])
                                    <i class="fa-solid fa-phone mr-3 text-{{ $contactIconColor }} text-md"></i>
                                    <span>{{ get_bloginfo('language') === 'nl-NL' ? $contactPhone->national() : $contactPhone->international() }}</span>
                                    @include('components.link.closing')
                                @endif

                                {{-- E-mail --}}
                                @if(in_array('establishment_mail', $establishmentElements) && $contactEmail = $contactEstablishment->getContactEmailAddress())
                                    @include('components.link.opening', [
                                        'href' => 'mailto:' . $contactEmail,
                                        'alt' => 'E-mailadres',
                                        'class' => 'email-text flex w-fit items-center'
                                    ])
                                    <i class="fa-solid fa-envelope mr-3 text-{{ $contactIconColor }} text-md"></i>
                                    <span>{{ $contactEmail }}</span>
                                    @include('components.link.closing')
                                @endif

                                {{-- Route --}}
                                @if(in_array('establishment_route', $establishmentElements) && $contactEstablishment->getAddress()->street)
                                    @php $addr = $contactEstablishment->getAddress(); @endphp
                                    @include('components.link.opening', [
                                        'href' => 'https://www.google.com/maps/search/?api=1&query=' . urlencode($addr->street . ' ' . $addr->full_housenumber . ' ' . $addr->postcode . ' ' . $addr->city),
                                        'alt' => 'Route',
                                        'class' => 'route-text flex w-fit items-center',
                                        'target' => '_blank'
                                    ])
                                    <i class="fa-solid fa-route mr-3 text-{{ $contactIconColor }} text-md"></i>
                                    <span>Route</span>
                                    @include('components.link.closing')
                                @endif

                                {{-- Openingstijden --}}
                                @if(in_array('establishment_opening_hours', $establishmentElements) && !empty($contactOpeningHours))
                                    @include('components.footer.establishment-opening-hours', [
                                        'establishmentElements' => $establishmentElements,
                                        'establishment' => $contactEstablishment,
                                        'opening_hours' => $contactOpeningHours
                                    ])
                                @endif

                                {{-- BTW & KvK --}}
                                @if((in_array('establishment_vat_number', $establishmentElements) && !empty($contactAcfData['vat_number'])) || (in_array('establishment_coc_number', $establishmentElements) && !empty($contactAcfData['coc_number'])))
                                    <div class="establishment-numbers">
                                        @if(in_array('establishment_vat_number', $establishmentElements) && !empty($contactAcfData['vat_number']))
                                            <div>BTW: {{ $contactAcfData['vat_number'] }}</div>
                                        @endif
                                        @if(in_array('establishment_coc_number', $establishmentElements) && !empty($contactAcfData['coc_number']))
                                            <div>KvK: {{ $contactAcfData['coc_number'] }}</div>
                                        @endif
                                    </div>
                                @endif

                            </div>
                        @endif

                        @if ($showSocials)
                            @include('components.socials.list')
                        @endif
                    </div>

                    @if ($sideImage)
                        <div class="side-image w-full xl:w-1/2 order-1 xl:order-2">
                            @include('components.image', [
                                'image_id' => $sideImage,
                                'size' => 'full',
                                'object_fit' => 'contain',
                                'img_class' => 'w-full',
                                'alt' => get_post_meta($sideImage, '_wp_attachment_image_alt', true) ?: 'Side image',
                            ])
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .cta-contact-{{ $randomNumber }}-custom-padding {
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

    .cta-contact-{{ $randomNumber }}-custom-margin {
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
