<nav id="site-navigation" class="main-navigation hidden lg:block">
    {!! wp_nav_menu([
        'theme_location' => 'menu-1',
        'menu_id' => 'primary-menu',
        'echo' => false
    ]) !!}
</nav>