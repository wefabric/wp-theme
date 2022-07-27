<div class="hidden lg:flex lg:flex-col py-4 text-base">
    <div class="flex justify-end pb-4">
        <div class="mr-3">
            <form action="" method="post" id="" name="" class="validate" target="_blank" novalidate>
                <div class="flex">
                    <input type="text" value="" placeholder="Typ hier je zoekterm in..." name="q" class="w-96 required bg-white rounded-l-lg shadow-lg shadow-slate-200 " id="search">
                    <div class="flex align-center">
                        <button type="submit" class="w-12 h-12 rounded-r-lg text-center
                        bg-black text-white text-center text-xl hover:bg-primary-dark shadow shadow-slate-200">
                            <i class="fa-light fa-search "></i>
                            <span class="screen-reader-only">Zoeken</span>
                        </button>
                        <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe" class="button">
                    </div>

                </div>
            </form>
        </div>

        @include('components.link.opening', [
            'href' => '/cart',
            'alt' => 'Winkelwagen',
/*            'rel' => 'noopener',
            'target' => '_blank'
*/        ])
            <span class="inline-block h-12 w-12 rounded-full mr-3 text-center pt-1.5
                bg-black hover:bg-primary-dark text-white relative">
                <i class="fa-light fa-bag-shopping text-xl"></i>
                <span class="screen-reader-only">Naar de winkelwagen</span>

                <span class="h-7 w-7 text-center mr-1 rounded-full bg-zinc-300 text-black absolute pt-0.5 -top-2 -right-2">
                    {{ $cart ?? 0 }}
                </span>
            </span>
        @include('components.link.closing')

        @include('components.link.opening', [
            'href' => '/profile',
            'alt' => 'Profiel',
  /*          'rel' => 'noopener',
            'target' => '_blank'
  */      ])
            <span class="inline-block h-12 w-12 rounded-full mr-3 text-center pt-1.5
                bg-black hover:bg-primary-dark text-white">
                <i class="fa-light fa-user text-xl"></i>
                <span class="screen-reader-only">Naar mijn profiel</span>
            </span>
        @include('components.link.closing')

    </div>

    <nav id="site-navigation" class="main-navigation">
        {{-- {!! wp_nav_menu([
            'theme_location' => 'menu-1',
            'menu_id' => 'primary-menu',
            'echo' => false
        ]) !!} --}}

        @php
            $class = 'inline-block hover:font-bold hover:underline md:px-4';

            $menuLocations = get_nav_menu_locations();
            $menuID = $menuLocations['menu-1'];
            $menu = wp_get_nav_menu_items($menuID);
        @endphp

        @include('components.header.home-house', [
            'class' => $class,
        ]) {{-- this shows a house icon, as link to the homepage. --}}

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
                <span class="divider"> </span>
            @endif
--}}
        @endforeach

        @include('components.link.opening', [
            'href' => '/offerte',
            'alt' => 'Offerte aanvragen',
        ])
            <span class="btn btn-small btn-primary-dark">
                Offerte aanvragen
            </span>
        @include('components.link.closing')

    </nav>
</div>
