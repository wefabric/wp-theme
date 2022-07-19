@php
    $options = get_fields('option');
    // dd($options);
@endphp

<div class="bg-black text-white text-base pb-24">
    <div class="container mx-auto px-8 lg:px-0 relative">

        <div class="w-full">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-16 px-5">
                <div class="pb-6 border-b md:border-0">
                    @php
                        $menu = wp_nav_menu([
                          'theme_location' => 'footer_menu_one',
                          'menu_id' => 'footer_menu_one',
                          'echo' => false
                        ]);
                    @endphp
                    @include('components.footer.accordion-menu', ['menu' => $menu, 'title' => wp_get_nav_menu_name('footer_menu_one'), 'accordionId' => 1, 'setAccordion' => true])
                </div>

                <div class="pb-6 border-b md:border-0">
                    @php
                        $menu = wp_nav_menu([
                          'theme_location' => 'footer_menu_two',
                          'menu_id' => 'footer_menu_two',
                          'echo' => false
                        ]);
                    @endphp

                    @include('components.footer.accordion-menu', ['menu' => $menu, 'title' => wp_get_nav_menu_name('footer_menu_two'), 'accordionId' => 2, 'setAccordion' => true])
                </div>

                <div class="pb-6 border-b md:border-0">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.contact'), 'title' => 'Contactgegevens', 'accordionId' => 3, 'setAccordion' => true])
                </div>

                <div class="pb-6 border-b md:border-0">
                    @include('components.footer.accordion-menu', ['menu' => view('components.footer.follow-us'), 'title' => 'Volg ons', 'accordionId' => 4, 'setAccordion' => true])
                </div>
            </div>
        </div>

        <div class="grid grid-cols-4 content-center">
            <div class="">
                @if(isset(get_field('common', 'option')['logo_white']) && $logoId = get_field('common', 'option')['logo_white'])
                    {!! wp_get_attachment_image( $logoId , 'employee-thumbnail', false, ['class' => 'mb-4 mx-auto lg:mx-0 inline-block']) !!}
                @endif
            </div>

            <div class="col-span-2 flex flex-col">
                <div class="flex flex-row">
                    @foreach(['a', 'b', 'c'] as $item)
                        <div class="w-10 md:px-2.5">
                            {{ $item }}
                        </div>
                    @endforeach {{-- Logos van partners --}}
                </div>
                <div class="flex flex-row">
                    @php
                        $class = 'my-3 lg:my-0 block md:inline-block hover:underline md:px-2';
                    @endphp

                    @if($termsOfService = get_field('terms_of_service', 'option'))
                        @include('components.link.simple', [
                            'href' => get_permalink($termsOfService),
                            'class' => $class,
                            'text' => __('Algemene voorwaarden', 'wefabric')
                        ]) /
                    @endif

                    @include('components.link.simple', [
                        'href' => get_privacy_policy_url(),
                        'class' => $class,
                        'text' => __('Privacy policy', 'wefabric')
                    ]) /

                    @if($cookiepolicy = get_field('cookie_policy', 'option'))
                        @include('components.link.simple', [
                            'href' => get_permalink($cookiepolicy),
                            'class' => $class,
                            'text' => __('Cookie beleid', 'wefabric')
                        ]) /
                    @endif

                    @if($sitemap = get_field('sitemap', 'option'))
                        @include('components.link.simple', [
                            'href' => get_permalink($sitemap),
                            'class' => $class,
                            'text' => __('Sitemap', 'wefabric')
                        ])
                    @endif

                </div>
            </div>

            <div class="flex align-right pb-0 pt-auto">
                <span class="pr-1">
                    Gerealiseerd door:
                </span>
                @include('components.link.opening', [
                    'href' => 'https://wefabric.nl/',
                    'alt' => 'Wefabric.nl'
                ])
                    <img src="@asset('images/footer/logo-wefabric.png')" max-width="100%" height="100%" class="wefabric-logo" alt="Wefabric logo - wefabric.nl"/>
                @include('components.link.closing')
            </div>
        </div>

    </div>
</div>
