<div class="bg-black text-white text-base pb-10 lg:pb-24">
    <div class="container mx-auto px-8 lg:px-0 relative">

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
                    @include('components.footer.accordion-menu', ['menu' => $menu, 'title' => wp_get_nav_menu_name('footer_menu_one'), 'accordionId' => 1, 'setAccordion' => true])
                </div>

                <div class="lg:pb-6">
                    @php
                        $menu = wp_nav_menu([
                          'theme_location' => 'footer_menu_two',
                          'menu_id' => 'footer_menu_two',
                          'echo' => false
                        ]);
                    @endphp

                    @include('components.footer.accordion-menu', ['menu' => $menu, 'title' => wp_get_nav_menu_name('footer_menu_two'), 'accordionId' => 2, 'setAccordion' => true])
                </div>

                <div class="lg:pb-6">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.contact'), 'title' => __('Contactgegevens', 'wefabric'), 'accordionId' => 3, 'setAccordion' => true])
                </div>

                <div class="lg:pb-6">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.follow-us'), 'title' => __('Volg ons', 'wefabric'), 'accordionId' => 4, 'setAccordion' => true])
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row">
            <div class="hidden lg:block lg:w-1/4">
                @if(isset(get_field('common', 'option')['logo_white']) && $logoId = get_field('common', 'option')['logo_white'])
                    {!! wp_get_attachment_image( $logoId , 'employee-thumbnail', false, ['class' => 'mx-auto lg:mx-0 inline-block']) !!}
                @endif
            </div>

            <div class="w-full lg:w-1/2 flex flex-col self-end">
                <div class="flex flex-row mb-5">
                    @php
                        $footer = get_fields('option')['footer_partners'];
                    @endphp

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
                </div>

                <div class="lg:flex lg:flex-row">
                    @php
                        $class = 'inline-block hover:underline md:px-2';

                        $menuLocations = get_nav_menu_locations();
                        $menuID = $menuLocations['footer_menu_three'];
                        $menu = wp_get_nav_menu_items($menuID);
                    @endphp

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
                </div>
            </div>

            <div class="w-full lg:w-1/4 flex">
                <div class="flex w-full pt-8 lg:pt-0 lg:text-right lg:self-end">
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
                        <img src="{{ $theme->getUrl('assets/images/footer/logo-wefabric-white.png') }}" max-width="100%" height="100%" class="wefabric-logo" alt="Wefabric logo - wefabric.nl" style="height:18px;"/>
                    @include('components.link.closing')
                </div>
            </div>
        </div>

    </div>
</div>
