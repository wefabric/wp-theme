@php
    $options = get_fields('option');
    if (!empty($options['nav']) && is_array($options['nav'])) {
        $options = array_merge($options, $options['nav']);
        if (!empty($options['nav']['desktop']) && is_array($options['nav']['desktop'])) {
            $options = array_merge($options, $options['nav']['desktop']);
        }
    }
    $isHomePage = is_front_page();
    $showHomeIcon = (bool) get_option('options_nav_desktop_desktop_show_home_icon', 1);
@endphp
<div class="main-nav-items hidden xl:flex lg:flex-col py-4 text-base">
    <nav id="site-navigation" class="main-navigation custom-width flex justify-end">

        @if ($showHomeIcon)
            @include('components.header.home-house', [
                'class' => 'md:px-4 text-xl hover:text-' . (isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'cta') . ' text-' . ($isHomePage && isset($options['menu_active_text_color']) ? str_replace('-color', '', $options['menu_active_text_color']) : 'primary') . ' text-'. (isset($options['menu_text_color']) ? str_replace('-color', '', $options['menu_text_color']) : 'black'),
            ])
        @endif

        @php
            $menuLocations = get_nav_menu_locations();
            $menuID = null;
            if(isset($menuLocations['menu-1'])) {
                $menuID = $menuLocations['menu-1'];
                $menu = wp_get_nav_menu_items($menuID);
            }
        @endphp

        @if (!empty($options['menu_navigation_text']))
            <div class="pre-navigation-text">{!! $options['menu_navigation_text'] !!}</div>
        @endif

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
