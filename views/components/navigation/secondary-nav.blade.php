@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }
@endphp

<div class="secondary-navigation hidden xl:block w-full bg-{{ $options['secondary_menu_background_color'] ?? '' }}">
    <div class="secondary-navigation-items flex items-center justify-between flex-row container mx-auto h-12 px-4">
        @if(isset($options['secondary_menu_text']))
            <div class="secondary-menu-text text-sm text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">{!! $options['secondary_menu_text'] !!}</div>
        @endif
        @if (!empty($options['secondary_menu_show_elements']))
            <div class="layout flex gap-4 text-sm h-full items-center text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">
                @foreach($footer_establishments as $key => $establishment)
                    @php
                        if ($establishment instanceof \Wefabric\WPEstablishments\Establishment) {
                           // If $establishment is an object
                           $phone = $establishment->getContactPhone();
                           $email = $establishment->getContactEmailAddress();
                        } elseif (is_array($establishment)) {
                           // If $establishment is an array
                           $establishment = new \Wefabric\WPEstablishments\Establishment($establishment['establishment']);
                           $phone = $establishment->getContactPhone();
                           $email = $establishment->getContactEmailAddress();
                        } else {
                           // Handle other cases if needed
                           $phone = '';
                           $email = '';
                        }
                    @endphp


                <div class="contact-info flex gap-x-4">
                    @if (in_array('phone', $options['secondary_menu_show_elements']))
                        <a class="phone-link group flex items-center gap-2" href="{{ $phone->uri() }}"
                           title="Telefoonnummer">
                            <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-phone"></i>
                            <span class="align-middle">{{ $phone->international() }}</span>
                        </a>
                    @endif

                    @if (in_array('email', $options['secondary_menu_show_elements']))
                        <a class="mail-link group flex items-center gap-2" href="mailto:{{ $email }}"
                           title="E-mailadres">
                            <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-envelope"></i>
                            <span class="align-middle">{{ $email }}</span>
                        </a>
                    @endif
                </div>

                @endforeach

                @if (in_array('top_navigation', $options['secondary_menu_show_elements']))
                    @php
                        $menuLocations = get_nav_menu_locations();
                        $menuID = null;
                        if(isset($menuLocations['top-navigation'])) {
                            $menuID = $menuLocations['top-navigation'];
                        }
                    @endphp

                    @if (isset($options['secondary_menu_navigation_text']))
                        <div class="pre-navigation-text">{!! $options['secondary_menu_navigation_text'] !!}</div>
                    @endif

                    @if(isset($menuID) && !is_null($menuID))
                        {!! wp_nav_menu([
                            'theme_location' => 'top-navigation',
                            'menu_id' => $menuID,
                            'container_class' => 'flex',
                            'li_class'  => 'li-class',
                            'li_active_class'  => '',
                            'before'  => '<i class="before-class"></i>',
                            'echo' => false
                        ]) !!}
                    @endif
                @endif

                @if (in_array('search', $options['secondary_menu_show_elements']))
                    <form class="hidden search-form-hidden search-form py-[8px] justify-center items-center" action="/">
                        <input type="search" class="rounded-l-lg w-[180px]" placeholder="Zoeken..." name="s">
                        <input type="submit"
                               class="rounded-r-lg w-[82px] flex justify-center px-8 text-white font-bold bg-primary-light h-full uppercase text-primary hover:bg-primary-dark cursor-pointer"
                               value="Zoek">
                    </form>
                    <a class="search-link group flex items-center gap-2" href="#">
                        <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-search"></i>
                    </a>

                    <script>
                        // Zoek het element met de class 'search-link'
                        const searchLink = document.querySelector('.search-link');

                        // Voeg een click event listener toe aan het gevonden element
                        searchLink.addEventListener('click', function (e) {
                            searchLink.classList.toggle('hidden');
                            // Voorkom het standaardgedrag van de link
                            e.preventDefault();
                            // Toon/verberg het element met de class 'search-form'
                            const searchForm = document.querySelector('.search-form');
                            searchForm.classList.toggle('hidden');
                            searchForm.classList.toggle('flex');
                        });
                    </script>
                @endif
            </div>
        @endif
    </div>
</div>
