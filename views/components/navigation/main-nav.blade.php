@php
    $options = get_fields('option');
@endphp

<nav id="site-navigation" class="main-navigation flex justify-end items-center">

    @php
        $menuLocations = get_nav_menu_locations();
        if(isset($menuLocations['menu-1'])) {
            $menuID = $menuLocations['menu-1'];
            $menu = wp_get_nav_menu_items($menuID);
        }
    @endphp

    @if($menuID)
        {!! wp_nav_menu([
            'theme_location' => 'menu-1',
            'menu_id' => $menuID,
            'li_class'  => 'text-'. (isset($options['menu_text_color']) ? str_replace('-color', '', $options['menu_text_color']) : 'black'),
            'li_active_class'  => 'text-'. (isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'white'),
            'echo' => false
        ]) !!}
    @endif

</nav>
