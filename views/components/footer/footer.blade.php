@php
    $option = get_fields('option');

    if(!empty($option) && array_key_exists('bg_color', $option)) {
		$bg_color = $option['bg_color'];
    }
    if(!empty($option) && array_key_exists('text_color', $option)) {
		$text_color = $option['text_color'];
    }
@endphp

<div class="bg-{{ $bg_color ?? 'black' }} text-{{ $text_color ?? 'white' }} text-base pb-10 lg:pb-24">
{{--
    @php
        if(!empty($option) && array_key_exists('footer_usps', $option)) {
	        $usps = $option['footer_usps'];
        }
    @endphp

    @if(!empty($usps))
        <div class="bg-white text-black py-10 lg:py-20 lg:text-lg">
            @include('components.blocks.usps-small', [
                'col_amount' => count($usps),
                'usps' => $usps,
            ])
        </div>
    @endif
--}}

    <div class="container mx-auto px-8 relative">

        <div class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 lg:gap-4 pt-12 lg:pt-16 pb-6 lg:pb-0">
                <div class="lg:pb-6">
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

                <div class="lg:pb-6">
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

                <div class="lg:pb-6">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.contact'),
                             'title' => !empty($footerTitles['footer_title_3']) ? $footerTitles['footer_title_3'] : __('Contactgegevens', 'wefabric'),
                             'accordionId' => 3,
                             'setAccordion' => true])
                </div>

                <div class="lg:pb-6">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.follow-us'),
                             'title' => !empty($footerTitles['footer_title_4']) ? $footerTitles['footer_title_4'] : __('Volg ons', 'wefabric'),
                             'accordionId' => 4,
                             'setAccordion' => true])
                </div>
            </div>
        </div>

        <div class="flex flex-col md:flex-row">
            <div class="hidden lg:block lg:w-1/4">
                @php
                    $settings = get_field('common', 'option');
                    if(!empty($settings)) {
						if(array_key_exists('logo_white', $settings)) {
							$logoId = $settings['logo_white'];
						} elseif(array_key_exists('logo', $settings)) {
							$logoId = $settings['logo'];
						}
                    }
                @endphp
                @if(!empty($logoId))
                    {!! wp_get_attachment_image($logoId, 'employee-thumbnail', false, ['class' => 'mx-auto lg:mx-0 inline-block']) !!}
                @endif
            </div>

            <div class="w-full md:w-1/2 flex flex-col self-end">
                <div class="flex flex-row mb-5">
                    @php
                        $footer = [];
                        if(!empty($option) && array_key_exists('footer_partners', $option)) {
                            $footer = $option['footer_partners'];
                        }
                    @endphp

                    @if($footer)
                        @foreach($footer as $item)
                            <div class="pr-5">
                                @if($item['url'])
                                    @include('components.link.opening', [
                                        'href' => $item['url'],
                                        'alt' => $item['alt_text']
                                    ])
                                @endif
                                    @include('components.image', [
                                        'image_id' => $item['logo'],
                                        'size' => 'footer-thumbnail',
                                    ])
                                @if($item['url'])
                                    @include('components.link.closing')
                                @endif
                            </div>
                        @endforeach {{-- Logos van partners --}}
                    @endif
                </div>

                <div class="lg:flex lg:flex-row">
                    @php
                        $class = 'inline-block hover:underline md:px-2';

                        $menuLocations = get_nav_menu_locations();
                        $menu = null;
                        if(isset($menuLocations['footer_menu_three']) && $menuID = $menuLocations['footer_menu_three']) {
                              $menu = wp_get_nav_menu_items($menuID);
                        }

                    @endphp

                    @if($menu)
                        @foreach($menu as $post)
                            @include('components.link.simple', [
                                'href' => $post->url,
                                'class' => $class,
                                'text' => __($post->title, 'wefabric')
                            ])

                            @php
                                $last = (in_array($post, $menu) && $post == end($menu));
                            @endphp
                            @if(!$last)
                                <span class="divider"> / </span>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="w-full md:w-1/2 xl:w-1/4 flex">
                <div class="flex w-full pt-8 lg:pt-0 self-end md:text-right md:justify-end items-center">
                    <span class="pr-1">
                        Gerealiseerd door:
                    </span>
                    @include('components.link.opening', [
                        'href' => 'https://wefabric.nl/',
                        'alt' => 'Wefabric.nl'
                    ])
                        @php
                            $theme = app('wp.theme');
                        @endphp
                        <img src="{{ $theme->getUrl('assets/images/footer/logo-wefabric-white.png') }}" class="wefabric-logo" alt="Wefabric logo - wefabric.nl" style="height:30px;"/>
                    @include('components.link.closing')
                </div>
            </div>
        </div>

    </div>
</div>
