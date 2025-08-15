@php
    $options = get_fields('option');
	$forceWebshop = true;
    $isHomePage = is_front_page();
@endphp
<div class="main-nav-items hidden xl:flex lg:flex-col py-4 text-base">
    <nav id="site-navigation" class="main-navigation custom-width flex justify-end">
        @include('components.header.home-house', [
            'class' => 'md:px-4 text-xl hover:text-' . (isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'cta') . ' text-' . ($isHomePage && isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'primary') . ' text-'. (isset($options['menu_text_color']) ? str_replace('-color', '', $options['menu_text_color']) : 'black'),
        ])

        @php
            $menuLocations = get_nav_menu_locations();
            $menuID = null;
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
