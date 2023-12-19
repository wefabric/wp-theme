@php
    $options = get_fields('option');
	$forceWebshop = true;
@endphp
<div class="hidden xl:flex lg:flex-col py-4 text-base">
    <nav id="site-navigation" class="main-navigation flex justify-end">
        @include('components.header.home-house', [
            'class' => 'md:px-4 text-xl hover:text-' . (isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'cta') . ' text-'. (isset($options['menu_text_color']) ? str_replace('-color', '', $options['menu_text_color']) : 'black'),
        ])

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
                'li_class'  => 'text-'. (isset($options['menu_text_color']) ? str_replace('-color', '', $options['menu_text_color']) : 'white'),
                'li_active_class'  => 'text-'. (isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'white'),
                'echo' => false
            ]) !!}
        @endif
    </nav>
</div>
