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


                @if (in_array('top_navigation', $options['secondary_menu_show_elements']))

                    {{-- Pre navigation text --}}
                    @if (isset($options['secondary_menu_navigation_text']))
                        <div class="pre-navigation-text">{!! $options['secondary_menu_navigation_text'] !!}</div>
                    @endif

                    @php
                        $menuLocations = get_nav_menu_locations();
                        $menuID = null;
                        if(isset($menuLocations['top-navigation'])) {
                            $menuID = $menuLocations['top-navigation'];
                        }
                    @endphp

                    {{-- Secondary navigation --}}
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

                        {{-- WhatsApp --}}
                        @if (in_array('whatsapp', $options['secondary_menu_show_elements']))
                            <a class="whatsapp-link group flex items-center" href="{{ $options['whatsapp'] }}"
                               title="WhatsApp">
                                <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-brands fa-whatsapp"></i>
                                <span class="align-middle"></span>
                            </a>
                        @endif

                        {{-- Phone number --}}
                        @if (in_array('phone', $options['secondary_menu_show_elements']))
                            <a class="phone-link group flex items-center gap-2" href="{{ $phone->uri() }}"
                               title="Telefoonnummer">
                                <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-phone"></i>
                                <span class="align-middle">{{ $phone->international() }}</span>
                            </a>
                        @endif

                        {{-- Email --}}
                        @if (in_array('email', $options['secondary_menu_show_elements']))
                            <a class="mail-link group flex items-center gap-2 email-hidden" href="mailto:{{ $email }}"
                               title="E-mailadres">
                                <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-envelope"></i>
                                <span class="align-middle">{{ $email }}</span>
                            </a>
                        @endif
                    </div>

                @endforeach

                {{-- Search --}}
                @if (in_array('search', $options['secondary_menu_show_elements']))

                    <div class="backdrop"></div>

                    <form class="search-form-hidden search-form gap-x-4 items-center justify-center h-[400px] shadow-xl" action="/">
                        <div class="search-input-container">
                            <input type="search"
                                   class="search-input"
                                   placeholder="Zoeken..." name="s">
                        </div>
                        <button type="submit"
                                class="p-4 rounded-full flex justify-center items-center font-bold bg-background-color hover:bg-primary hover:scale-110 text-black hover:text-white cursor-pointer transition-transform duration-300 ease-in-out">
                            <i class="fa fa-search"></i>
                        </button>
                    </form>

                    <a class="search-link group flex items-center gap-2" href="#">
                        <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-search"></i>
                    </a>

                        <script>
                            const searchLink = document.querySelector('.search-link');
                            const searchForm = document.querySelector('.search-form');
                            const searchInputContainer = document.querySelector('.search-input-container');
                            const backdrop = document.querySelector('.backdrop');

                            function toggleSearchForm() {
                                if (!searchForm || !searchInputContainer || !backdrop) return;

                                const isHidden = searchForm.classList.contains('search-form-hidden');

                                if (isHidden) {
                                    searchForm.classList.remove('slide-up');
                                    searchForm.classList.add('slide-down');
                                    backdrop.style.display = 'block';
                                    setTimeout(() => {
                                        searchForm.classList.remove('search-form-hidden');
                                    }, 0);
                                } else {
                                    searchForm.classList.remove('slide-down');
                                    searchForm.classList.add('slide-up');

                                    searchForm.addEventListener('animationend', function handleAnimationEnd() {
                                        searchForm.classList.add('search-form-hidden');
                                        backdrop.style.display = 'none';
                                        searchForm.removeEventListener('animationend', handleAnimationEnd);
                                    });
                                }

                                if (isHidden) {
                                    setTimeout(() => {
                                        searchInputContainer.classList.add('animate-border');
                                    }, 200);
                                } else {
                                    searchInputContainer.classList.remove('animate-border');
                                }
                            }

                            if (searchLink) {
                                searchLink.addEventListener('click', function (e) {
                                    e.preventDefault();
                                    toggleSearchForm();
                                });
                            }

                            if (backdrop) {
                                backdrop.addEventListener('click', toggleSearchForm);
                            }
                        </script>

                    @endif


            </div>
        @endif
    </div>
</div>
