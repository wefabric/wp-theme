@php
    $option = get_fields('option');
	if(!empty($option)) {
		if(array_key_exists('bg_color', $option)) {
			$bg_color = $option['bg_color'];
		}
		if(array_key_exists('text_color', $option)) {
			$text_color = $option['text_color'];
		}
        if(array_key_exists('title_color', $option)) {
			$title_color = $option['title_color'];
		}
	}

    $footerTitles = $option['footer_titles'] ?? [];

    $visibleFooterElements = $option['footer_elements'] ?? [];
    $privacyPage = $option['pages']['privacy_page'] ?? '';
    $termsPage = $option['pages']['terms_page'] ?? '';

    $sectionTypes = [
        1 => $option['footer_section_1_type'] ?? 'menu_1',
        2 => $option['footer_section_2_type'] ?? 'menu_2',
        3 => $option['footer_section_3_type'] ?? 'contact',
        4 => $option['footer_section_4_type'] ?? 'newsletter',
    ];

    // Default true: uitklapbaar tenzij expliciet uitgeschakeld
    $mobileAccordion = !isset($option['footer_mobile_accordion']) || $option['footer_mobile_accordion'];

    $defaultTitles = [
        'menu_1'      => wp_get_nav_menu_name('footer_menu_one'),
        'menu_2'      => wp_get_nav_menu_name('footer_menu_two'),
        'menu_3'      => wp_get_nav_menu_name('footer_menu_three'),
        'contact'     => __('Contactgegevens', 'wefabric'),
        'newsletter'  => __('Volg ons', 'wefabric'),
        'custom_text' => '',
    ];

    $sectionTitles = [
        1 => !empty($footerTitles['footer_title_1']) ? $footerTitles['footer_title_1'] : ($defaultTitles[$sectionTypes[1]] ?? ''),
        2 => !empty($footerTitles['footer_title_2']) ? $footerTitles['footer_title_2'] : ($defaultTitles[$sectionTypes[2]] ?? ''),
        3 => !empty($footerTitles['footer_title_3']) ? $footerTitles['footer_title_3'] : ($defaultTitles[$sectionTypes[3]] ?? ''),
        4 => !empty($footerTitles['footer_title_4']) ? $footerTitles['footer_title_4'] : ($defaultTitles[$sectionTypes[4]] ?? ''),
    ];

    $menuLocations = [
        'menu_1' => 'footer_menu_one',
        'menu_2' => 'footer_menu_two',
        'menu_3' => 'footer_menu_three',
    ];

    $activeSectionCount = count(array_filter($sectionTypes, fn($t) => $t !== 'none' && !empty($t)));
    $gridColsMap = [1 => 'lg:grid-cols-1', 2 => 'lg:grid-cols-2', 3 => 'lg:grid-cols-3', 4 => 'lg:grid-cols-4'];
    $gridColsClass = $gridColsMap[$activeSectionCount] ?? 'lg:grid-cols-4';
@endphp

<div class="footer bg-{{ $bg_color ?? '' }} text-{{ $text_color ?? 'white' }} text-base">
    @if(!empty($usps))
        <div class="bg-white text-black py-10 lg:py-20 px-4 md:px-8 lg:px-36">
            @include('components.slider.grid', [
                'items' => $usps,
                'card_type' => 'usp',
                'grid_class' => 'flex flex-col lg:flex-row justify-center',

                'size' => '3xl',
                'style' => 'p font-bold lg:h6',
                'class' => 'mx-auto w-full lg:w-4/5',
                'usp_class' => 'w-full mx-auto',
            ])
        </div>
    @endif

    @if(!empty($option['footer_top_show']))
        @include('components.footer.footer-top')
    @endif

    <div class="footer-main custom-styling relative">
        <div class="container mx-auto px-8 relative">

            <div class="w-full">
                <div class="footer-grid grid grid-cols-1 md:grid-cols-2 {{ $gridColsClass }} lg:gap-8 pt-12 lg:pt-16 pb-6 lg:pb-0">

                    @foreach([1, 2, 3, 4] as $sectionNum)
                        @php
                            $sectionType = $sectionTypes[$sectionNum];
                            $sectionTitle = $sectionTitles[$sectionNum];
                        @endphp

                        @if($sectionType === 'none' || empty($sectionType))
                            @continue
                        @endif

                        <div class="lg:pb-6 section-{{ $sectionNum }}-type-{{ $sectionType }}">
                            @if(isset($menuLocations[$sectionType]))
                                @php
                                    $menuLocation = $menuLocations[$sectionType];
                                    $menu = wp_nav_menu([
                                        'theme_location' => $menuLocation,
                                        'menu_id'        => $menuLocation,
                                        'echo'           => false
                                    ]);
                                @endphp
                                @include('components.footer.accordion-menu', [
                                    'menu'        => $menu,
                                    'title'       => $sectionTitle,
                                    'accordionId' => $sectionNum,
                                    'setAccordion' => $mobileAccordion
                                ])
                            @elseif($sectionType === 'contact')
                                @include('components.footer.accordion-menu', [
                                    'menu'        => view('components.footer.contact'),
                                    'title'       => $sectionTitle,
                                    'accordionId' => $sectionNum,
                                    'setAccordion' => $mobileAccordion
                                ])
                            @elseif($sectionType === 'newsletter')
                                @include('components.footer.accordion-menu', [
                                    'menu'        => view('components.footer.follow-us'),
                                    'title'       => $sectionTitle,
                                    'accordionId' => $sectionNum,
                                    'setAccordion' => $mobileAccordion
                                ])
                            @elseif($sectionType === 'logos')
                                @php
                                    $logosData = $option['footer_section_' . $sectionNum . '_logos'] ?? [];
                                @endphp
                                @include('components.footer.accordion-menu', [
                                    'menu'        => view('components.footer.logos-section', [
                                        'logos' => $logosData,
                                    ]),
                                    'title'       => $sectionTitle,
                                    'accordionId' => $sectionNum,
                                    'setAccordion' => $mobileAccordion
                                ])
                            @elseif($sectionType === 'custom_text')
                                @php
                                    $customData        = $option['footer_section_' . $sectionNum . '_custom'] ?? [];
                                    $customText        = $customData['text'] ?? '';
                                    $customButtonLink  = $customData['button_link'] ?? null;
                                    $customButtonColor = $customData['button_color'] ?? 'primary-color';
                                    $customButtonStyle = $customData['button_style'] ?? 'filled';
                                    $customButtonIcon  = $customData['button_icon'] ?? '';
                                    $customButtonDownload = $customData['button_download'] ?? false;
                                @endphp
                                @include('components.footer.accordion-menu', [
                                    'menu'        => view('components.footer.custom-section', [
                                        'customText'           => $customText,
                                        'customButtonLink'     => $customButtonLink,
                                        'customButtonColor'    => $customButtonColor,
                                        'customButtonStyle'    => $customButtonStyle,
                                        'customButtonIcon'     => $customButtonIcon,
                                        'customButtonDownload' => $customButtonDownload,
                                    ]),
                                    'title'       => $sectionTitle,
                                    'accordionId' => $sectionNum,
                                    'setAccordion' => $mobileAccordion
                                ])
                            @endif
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    @if(isset($option['footer_secondary_establishments']) && $option['footer_secondary_establishments'])
        <div class="establishments-list relative py-8 my-8">
            <div class="container mx-auto px-8">
                @include ('components.footer.establishments-swiper')
            </div>
        </div>
    @endif

    <div class="footer-bottom bottom-info relative ">
        <div class="custom-flex-styling container mx-auto px-8 flex flex-col md:flex-row pb-6">
            @php
                $options = get_fields('option');
                $logoMap = [
                    'logo_1'       => 'logo',
                    'logo_2'       => 'logo_white',
                    'logo_3'       => 'logo_3',
                    'logo_1_small' => 'logo_1_small',
                    'logo_2_small' => 'logo_2_small',
                    'logo_3_small' => 'logo_3_small',
                ];
                $footerLogoToDisplay = $logoMap[$options['footer_logo'] ?? 'logo_1'] ?? 'logo';
                $showFooterLogo      = !empty($visibleFooterElements) && in_array('logo', $visibleFooterElements);
                $showFooterCopyright = !empty($visibleFooterElements) && in_array('copyright', $visibleFooterElements);
            @endphp

            @if($showFooterLogo || $showFooterCopyright)
            <div class="logo-section flex flex-col justify-end lg:w-1/4 lg:pr-8">

                @if($showFooterLogo)
                    <div class="footer-logo hidden lg:block">
                        @if(isset(get_field('common', 'option')[$footerLogoToDisplay]) && $logoId = get_field('common', 'option')[$footerLogoToDisplay])
                            {!! wp_get_attachment_image($logoId, 'footer_logo', false, ['class' => 'footer-logo-image']) !!}
                        @endif
                    </div>
                @endif

                @if($showFooterCopyright)
                    <div class="copyright-text">© {{ date('Y') }} {{ get_bloginfo('name') }}</div>
                @endif
            </div>
            @endif

            <div class="partners-section w-full md:w-1/2 flex flex-col self-end">
                @php
                    $footer = [];
                    if(!empty($option) && array_key_exists('footer_partners', $option)) {
                        $footer = $option['footer_partners'];
                    }
                @endphp
                @if($footer)
                    <div class="partner-list flex flex-row mb-5 gap-x-4 justify-center md:justify-start">
                        @foreach($footer as $item)
                            <div class="flex items-center">
                                @if($item['url'])
                                    @include('components.link.opening', [
                                        'href' => $item['url'],
                                        'alt' => $item['alt_text']
                                    ])
                                @endif
                                @include('components.image', [
                                    'image_id' => $item['logo'],
                                    'size' => 'full',
                                    'class' => 'disable-rounded',
                                ])
                                @if($item['url'])
                                    @include('components.link.closing')
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="footer-pages text-center md:text-left text-[14px]">
                    @if($termsPage)
                        <a class="terms-text underline"
                           href="{{ get_permalink($termsPage) }}">{{ get_the_title($termsPage) }}</a> @if($termsPage && $privacyPage)
                            |
                        @endif
                    @endif
                    @if($privacyPage)
                        <a class="privacy-text underline"
                           href="{{ get_permalink($privacyPage) }}">{{ get_the_title($privacyPage) }}</a>
                    @endif
                </div>

            </div>

            <div class="created-section w-full md:w-1/2 xl:w-1/4 flex">
                <div class="created-layout flex w-full pt-8 lg:pt-0 self-end md:text-right items-center justify-center md:justify-end">
                        <span class="created-text pr-1">
                            {{ __('Gerealiseerd door:', 'themosis') }}
                        </span>
                    @include('components.link.opening', [
                        'href' => 'https://wefabric.nl/',
                        'alt' => 'Wefabric.nl'
                    ])
                    @php
                        $theme = app('wp.theme');
                    @endphp

                    <img src="{{ !empty($options['wefabric_logo_color']) && $options['wefabric_logo_color'] == 'white' ? $theme->getUrl('assets/images/footer/logo-wefabric-white.png') : $theme->getUrl('assets/images/footer/logo-wefabric-black.png') }}"
                         width="92" height="20"
                         class="wefabric-logo hover:scale-105 transition-all ease-in-out"
                         alt="Wefabric logo - wefabric.nl" style="height:20px;"/>
                    <span class="screen-reader-only">Wefabric</span>
                    @include('components.link.closing')
                </div>
            </div>
        </div>
    </div>

    @if($options['show_logo_section'] && !empty($option['logos']['logos']))
        <div class="footer-logos-section bg-{{ $options['logo_section_background_color'] ?? 'white' }}">
            <div class="container mx-auto px-8">
                @include ('components.footer.logo-slider')
            </div>
        </div>
    @endif

</div>
