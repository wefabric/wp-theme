@php
    $options = get_fields('option');
    $footer_establishments = array_key_exists('footer_establishments', $options) ? $options['footer_establishments'] : [];

    if (empty($footer_establishments) || empty($footer_establishments[0])) {
        $footer_establishments = [\Wefabric\WPEstablishments\Establishment::primary()];
    }
@endphp

<div class="secondary-navigation hidden lg:block w-full bg-{{ $options['secondary_menu_background_color'] ?? 'primary-color' }}">
    <div class="flex items-center justify-between flex-row container mx-auto h-12 px-4">
        @if(isset($options['secondary_menu_text']))
            <div class="secondary-menu-text font-bold text-sm text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">{{ $options['secondary_menu_text'] }}</div>
        @endif
        @if (!empty($options['secondary_menu_show_elements']))
            <div class="flex gap-4 text-sm h-full text-{{ $options['secondary_menu_text_color'] ?? 'white' }}">
                @foreach($footer_establishments as $key => $establishment_config)
                    @php
                        $establishment = $establishment_config ? new \Wefabric\WPEstablishments\Establishment($establishment_config['establishment']) : null;
                        $phone = $establishment ? $establishment->getContactPhone() : '';
                        $email = $establishment ? $establishment->getContactEmailAddress() : '';
                    @endphp
                    @if (in_array('phone', $options['secondary_menu_show_elements']))
                        <a class="phone-link group flex items-center gap-2" href="tel:{{ $phone }}"
                           title="Telefoonnummer">
                            <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-phone"></i>
                            <span class="align-middle ">{{ $phone }}</span>
                        </a>
                    @endif

                    @if (in_array('email', $options['secondary_menu_show_elements']))
                        <a class="mail-link group flex items-center gap-2" href="mailto:{{ $email }}"
                           title="E-mailadres">
                            <i class="p-1.5 flex justify-center items-center bg-primary-light group-hover:bg-primary-dark rounded-lg fa-solid fa-envelope"></i>
                            <span class="align-middle">{{ $email }}</span>
                        </a>
                    @endif
                @endforeach
                @php
                    $menuLocations = get_nav_menu_locations();
                    $menuID = null;
                    if(isset($menuLocations['top-navigation'])) {
                        $menuID = $menuLocations['top-navigation'];
                    }
                @endphp
                @if(isset($menuID) && !is_null($menuID))
                    {!! wp_nav_menu([
                        'theme_location' => 'top-navigation',
                        'menu_id' => $menuID,
                        'container_class' => 'flex',
                        'li_class'  => 'group flex items-center gap-2 bg-primary hover:bg-primary-light rounded-b-md p-4 h-5/6 text-white',
                        'li_active_class'  => '',
                        'before'  => '<i class="p-1.5 flex text-md justify-center items-center rounded-lg fa-solid fa-user"></i>',
                        'echo' => false
                    ]) !!}
                @endif
            </div>
        @endif
    </div>
</div>
