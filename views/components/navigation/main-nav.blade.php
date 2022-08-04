<div class="hidden lg:flex lg:flex-col py-4 text-base">

    @if(false) {-- hide webshop parts --}
    <div class="flex justify-end pb-4">

        <div class="mr-3">
            <form action="" method="post" id="" name="" class="validate" target="_blank" novalidate>
                <div class="flex">
                    <input type="text" value="" placeholder="Typ hier je zoekterm in..." name="q" class="w-96 required bg-white rounded-l-lg shadow-lg shadow-slate-200 " id="search">
                    <div class="flex align-center">
                        <button type="submit" class="w-12 h-12 rounded-r-lg text-center bg-black text-white text-center text-xl hover:bg-primary-dark shadow shadow-slate-200">
                            <i class="fa-light fa-search "></i>
                            <span class="screen-reader-only">Zoeken</span>
                        </button>
                        <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
                    </div>

                </div>
            </form>
        </div>

        @include('components.buttons.icon', [
            'href' => '/cart',
            'alt' => 'Naar de winkelwagen',
//            'rel' => 'noopener',
//            'target' => '_blank',
            'icon' => 'fa-light fa-bag-shopping',

            'size' => 'h-12 w-12 pt-1.5',
            'colors' => 'bg-black hover:bg-primary-dark text-white',
            'class' => 'relative',

            'smallIconClass' => 'h-7 w-7 text-center mr-1 rounded-full bg-zinc-300 text-black absolute pt-0.5 -top-2 -right-2',
            'smallIconContent' => '0', //number of items in shopping cart
        ])

        @include('components.buttons.icon', [
            'href' => '/profile',
            'alt' => 'Naar mijn profiel',
//            'rel' => 'noopener',
//            'target' => '_blank',
            'icon' => 'fa-light fa-user',

            'size' => 'h-12 w-12 pt-1.5',
            'colors' => 'bg-black hover:bg-primary-dark text-white',
        ])
    </div>
    @endif

    <nav id="site-navigation" class="main-navigation flex justify-end items-center">
        {{-- {!! wp_nav_menu([
            'theme_location' => 'menu-1',
            'menu_id' => 'primary-menu',
            'echo' => false
        ]) !!} --}}

        @php
            $class = 'inline-block font-bold hover:underline md:px-4 uppercase';

            $menuLocations = get_nav_menu_locations();
            $menuID = $menuLocations['menu-1'];
            $menu = wp_get_nav_menu_items($menuID);
        @endphp

        @if(false)
            @include('components.header.home-house', [
                'class' => $class,
            ]) {{-- this shows a house icon, as link to the homepage. --}}
        @endif

        @foreach($menu as $link)
            {{--
                        @php
                            $isLast = (in_array($link, $menu) && $link == end($menu));
                        @endphp
            --}}
            @include('components.link.simple', [
                'href' => $link->url,
                'class' => $class,
                'text' => __($link->title, 'wefabric')
            ])
            {{--
                        @if(!$isLast)
                            <span class="divider"> / </span>
                        @endif
            --}}
        @endforeach

        @if(false) {{-- hide webshop parts --}}
        @include('components.buttons.default', [
            'href' => '/offerte',
            'text' => 'Offerte aanvragen',
            'colors' => 'btn-primary-dark text-white'
        ])
        @endif

        @php
            $icon_classes = 'text-xl px-1.5 font-normal';
        @endphp

        @include('components.header.email', [
            'class' => $icon_classes,
        ])

        @include('components.header.phone', [
            'class' => $icon_classes,
        ])

    </nav>
</div>