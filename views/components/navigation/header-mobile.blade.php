{{--<input type="checkbox" class="hidden" id="nav-mobile-active">--}}
{{--<div class="logo-mobile float-left lg:hidden z-10 relative">--}}
{{--    <div class="site-title">--}}
{{--        <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">--}}
{{--            @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])--}}
{{--                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'max-h-12 w-auto']) !!}--}}
{{--            @endif--}}
{{--        </a>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>--}}
{{--<header class="banner absolute left-0 w-full">--}}
{{--    <div>--}}
{{--        <div class="py-2 pr-16 flex items-center justify-end relative lg:hidden">--}}
{{--			@php--}}
{{--				$icon_size = 'h-8 w-8 pt-1 mr-3';--}}

{{--				$cart_items = WC()->cart->get_cart_contents_count();--}}
{{--				$cart_total = WC()->cart->get_cart_total(); //price?--}}
{{--			@endphp--}}
{{--			--}}
{{--			@include('components.buttons.icon', [--}}
{{--				'href' => wc_get_cart_url(),--}}
{{--				'alt' => 'Naar de winkelwagen',--}}
{{--			//            'rel' => 'noopener',--}}
{{--			//            'target' => '_blank',--}}
{{--				'icon' => 'fa-regular fa-bag-shopping text-base',--}}
{{--			--}}
{{--				'size' => $icon_size,--}}
{{--				'colors' => 'btn-black text-white',--}}
{{--				'class' => 'relative',--}}
{{--			--}}
{{--				'smallIconClass' => 'min-h-[1.25rem] min-w-[1.25rem] p-1 text-center text-sm mr-1 rounded-full bg-zinc-300 text-xs text-black absolute -mt-0.5 -top-2 -right-2',--}}
{{--				'smallIconContent' => $cart_items, //number of items in shopping cart--}}
{{--			])--}}
{{--	--}}
{{--			@include('components.buttons.icon', [--}}
{{--				'href' => get_permalink(get_option('woocommerce_myaccount_page_id')),--}}
{{--				'alt' => 'Naar mijn profiel',--}}
{{--	//            'rel' => 'noopener',--}}
{{--	//            'target' => '_blank',--}}
{{--				'icon' => 'fa-regular fa-user text-base',--}}

{{--				'size' => $icon_size,--}}
{{--				'colors' => 'btn-black text-white',--}}
{{--			])--}}
{{--	--}}
{{--			<div class="hamburger-menu z-50">--}}
{{--				<label for="nav-mobile-active" class="mb-0 toggle-mobile-menu hamburger-button flex flex-col ">--}}
{{--					<span class="hamburger-button-bar"></span>--}}
{{--					<span class="hamburger-button-bar"></span>--}}
{{--					<span class="hamburger-button-bar"></span>--}}
{{--				</label>--}}
{{--			</div>--}}
{{--        </div>--}}
{{--        <div class="mobile-menu-wrap">--}}
{{--            <nav class="mobile-menu">--}}
{{--                <div class="mb-3 mobile-logo">--}}
{{--                    @include('components.header.logo', ['type' => 'white'])--}}
{{--                </div>--}}
{{--                <div class="mb-4">--}}
{{--                    @include('woocommerce.search.search')--}}
{{--                </div>--}}
{{--                <nav id="site-navigation" class="main-navigation">--}}
{{--                    {!! wp_nav_menu([--}}
{{--                        'theme_location' => 'menu-1',--}}
{{--                        'menu_id' => 'primary-menu',--}}
{{--                        'echo' => false--}}
{{--                    ]) !!}--}}
{{--                </nav>--}}
{{--            </nav>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</header>--}}
