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

//    @dd($option['logo_slider']);
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

    <div class="custom-styling relative">
        <div class="container mx-auto px-8 relative">

            <div class="w-full">
                <div class="footer-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 lg:gap-8 pt-12 lg:pt-16 pb-6 lg:pb-0">

                    <div class="lg:pb-6 menu-1-section">
                        @php
                            $menu = wp_nav_menu([
                                'theme_location' => 'footer_menu_one',
                                'menu_id' => 'footer_menu_one',
                                'echo' => false
                            ]);
                        @endphp
                        @include('components.footer.accordion-menu', ['menu' => $menu,
                            'title' => !empty($footerTitles['footer_title_1']) ? $footerTitles['footer_title_1'] : wp_get_nav_menu_name('footer_menu_one'),
                            'accordionId' => 1,
                            'setAccordion' => true])
                    </div>

                    <div class="lg:pb-6 menu-2-section">
                        @php
                            $menu = wp_nav_menu([
                                'theme_location' => 'footer_menu_two',
                                'menu_id' => 'footer_menu_two',
                                'echo' => false
                            ]);
                        @endphp

                        @include('components.footer.accordion-menu', ['menu' => $menu,
                            'title' => !empty($footerTitles['footer_title_2']) ? $footerTitles['footer_title_2'] : wp_get_nav_menu_name('footer_menu_two'),
                            'accordionId' => 2,
                            'setAccordion' => true])
                    </div>

                    <div class="lg:pb-6 contact-section">
                        @include('components.footer.accordion-menu', ['menu' => view('components.footer.contact'),
                            'title' => !empty($footerTitles['footer_title_3']) ? $footerTitles['footer_title_3'] : __('Contactgegevens', 'wefabric'),
                            'accordionId' => 3,
                            'setAccordion' => true])
                    </div>


                    <div class="lg:pb-6 follow-section">
                        @include('components.footer.accordion-menu', ['menu' => view('components.footer.follow-us'),
                            'title' => !empty($footerTitles['footer_title_4']) ? $footerTitles['footer_title_4'] : __('Volg ons', 'wefabric'),
                            'accordionId' => 4,
                            'setAccordion' => true])
                    </div>
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

    <div class="bottom-info relative ">
        <div class="custom-flex-styling container mx-auto px-8 flex flex-col md:flex-row pb-6">
            <div class="logo-section flex flex-col justify-end lg:w-1/4 lg:pr-8">

                @php
                    $options = get_fields('option');
                    $footerLogoToDisplay = '';

                    if (isset($options['footer_logo']) && $options['footer_logo'] === 'logo_2') {
                        $footerLogoToDisplay = 'logo_white';
                    } else {
                        $footerLogoToDisplay = 'logo';
                    }
                @endphp

                @if (!empty($visibleFooterElements) && in_array('logo', $visibleFooterElements))
                    <div class="footer-logo hidden lg:block">
                        @if(isset(get_field('common', 'option')[$footerLogoToDisplay]) && $logoId = get_field('common', 'option')[$footerLogoToDisplay])
                            {!! wp_get_attachment_image($logoId, 'footer_logo', false, ['class' => 'footer-logo-image']) !!}
                        @endif
                    </div>
                @endif

                @if (!empty($visibleFooterElements) && in_array('copyright', $visibleFooterElements))
                    <div class="copyright-text">© {{ date('Y') }} {{ get_bloginfo('name') }}</div>
                @endif
            </div>

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