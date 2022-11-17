@php
    $options = get_fields('option');
	$forceWebshop = true;
@endphp
<div class="hidden lg:flex lg:flex-col py-4 text-base">
	
	@if($forceWebshop || woocommerce_active()) {{-- webshop parts --}}
        <div class="flex justify-end pb-4">

            <div class="mr-3">
                <form action="/shop" method="get" id="" name="" class="validate" target="" novalidate>
                    <div class="flex">
                        <input type="text" value="" placeholder="Typ hier je zoekterm in..." name="s" class="hidden w-96 bg-white rounded-l-lg shadow-lg shadow-slate-200 " id="search">
                        <div class="flex align-center">
                            <button type="submit" class="w-12 h-12 rounded-full text-center btn-black text-white text-center text-xl shadow shadow-slate-200">
                                <i class="fa-light fa-search "></i>
                                <span class="screen-reader-only">Zoeken</span>
                            </button>
                            <input type="submit" value="" name="subscribe" id="mc-embedded-subscribe">
                        </div>

                    </div>
                </form>
            </div>

			@php
				$cart_items = WC()->cart->get_cart_contents_count();
				$cart_total = WC()->cart->get_cart_total(); //price?
			@endphp
			
            @include('components.buttons.icon', [
                'href' => wc_get_cart_url(),
                'alt' => 'Naar de winkelwagen',
    //            'rel' => 'noopener',
    //            'target' => '_blank',
                'icon' => 'fa-light fa-bag-shopping text-xl',

                'size' => 'h-12 w-12 pt-1.5 mr-3',
                'colors' => 'btn-black text-white',
                'class' => 'relative',

                'smallIconClass' => 'min-h-7 min-w-7 p-1 text-center mr-1 rounded-full bg-zinc-300 text-black text-xs absolute pt-0.5 -top-2 -right-2',
                'smallIconContent' => $cart_items, //sprintf(_n('%d item', '%d items', $cart_items), $cart_items) .' - '. $cart_total, //number of items in shopping cart
            ])

            @include('components.buttons.icon', [
                'href' => get_permalink(get_option('woocommerce_myaccount_page_id')),
                'alt' => 'Naar mijn profiel',
    //            'rel' => 'noopener',
    //            'target' => '_blank',
                'icon' => 'fa-light fa-user text-xl',

                'size' => 'h-12 w-12 pt-1.5 mr-3',
                'colors' => 'btn-black text-white',
            ])
        </div>
    @endif

    <nav id="site-navigation" class="main-navigation flex justify-end items-center mt-2">
        @include('components.header.home-house', [
            'class' => 'md:px-4 text-xl text-primary', //this shows a house icon, as link to the homepage
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
		
{{--
        @php
            $icon_classes = 'text-xl px-1.5 font-normal';
        @endphp

		@include('components.header.email', [
			'class' => $icon_classes,
			'a_class' => 'no-underline'
		])

		@include('components.header.phone', [
			'class' => $icon_classes,
			'a_class' => 'no-underline'
		])
--}}
		
    </nav>
</div>
