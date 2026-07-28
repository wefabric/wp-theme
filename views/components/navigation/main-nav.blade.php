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

<script>
(function () {
    function initMainNavSearch() {
        var searchItems = document.querySelectorAll('#site-navigation .search-button > a, #site-navigation li.search-button > a');
        if (!searchItems.length) { return; }

        // Ensure search form + backdrop exist in the DOM (may already exist from secondary-nav)
        if (!document.querySelector('.search-form')) {
            var backdropEl = document.createElement('div');
            backdropEl.className = 'backdrop';
            document.body.appendChild(backdropEl);

            var formEl = document.createElement('form');
            formEl.className = 'search-form-hidden search-form gap-x-4 items-center justify-center h-[400px] shadow-xl';
            formEl.setAttribute('action', '/');
            formEl.innerHTML = '<div class="search-input-container">'
                + '<input type="search" class="search-input" placeholder="Zoeken..." name="s">'
                + '</div>'
                + '<button type="submit" class="p-4 rounded-full flex justify-center items-center font-bold bg-background-color hover:bg-primary hover:scale-110 text-black hover:text-white cursor-pointer transition-transform duration-300 ease-in-out">'
                + '<i class="fa fa-search"></i>'
                + '</button>';
            document.body.appendChild(formEl);

            var searchForm = formEl;
            var searchInputContainer = formEl.querySelector('.search-input-container');
            var searchInput = formEl.querySelector('.search-input');
            var backdrop = backdropEl;

            window.wefabricToggleSearch = function () {
                if (!searchForm || !searchInputContainer || !backdrop) { return; }

                var isHidden = searchForm.classList.contains('search-form-hidden');

                if (isHidden) {
                    searchForm.classList.remove('slide-up');
                    searchForm.classList.add('slide-down');
                    backdrop.classList.add('backdrop-visible');
                    document.body.style.overflow = 'hidden';
                    setTimeout(function () {
                        searchForm.classList.remove('search-form-hidden');
                        searchInput.focus();
                    }, 0);
                } else {
                    searchForm.classList.remove('slide-down');
                    searchForm.classList.add('slide-up');
                    document.body.style.overflow = '';
                    searchForm.addEventListener('animationend', function handleAnimationEnd() {
                        searchForm.classList.add('search-form-hidden');
                        backdrop.classList.remove('backdrop-visible');
                        searchForm.removeEventListener('animationend', handleAnimationEnd);
                    });
                }

                if (isHidden) {
                    setTimeout(function () { searchInputContainer.classList.add('animate-border'); }, 200);
                } else {
                    searchInputContainer.classList.remove('animate-border');
                }
            };

            backdrop.addEventListener('click', window.wefabricToggleSearch);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !searchForm.classList.contains('search-form-hidden')) {
                    window.wefabricToggleSearch();
                }
            });
        }

        // Transform each desktop search-button menu link into a search trigger
        searchItems.forEach(function (link) {
            link.innerHTML = '<i class="fa-solid fa-search"></i>';
            link.setAttribute('href', '#');
            link.classList.add('nav-search-trigger');
            link.addEventListener('click', function (e) {
                e.preventDefault();
                if (typeof window.wefabricToggleSearch === 'function') {
                    window.wefabricToggleSearch();
                }
            });
        });

        // Hide search-button items in mobile menus (we add a proper mobile trigger instead)
        document.querySelectorAll('.mobile-menu .search-button, .mnav2-overlay .search-button').forEach(function (li) {
            li.style.display = 'none';
        });

        // Add search icon to hamburger navigation area
        var hamburgerNav = document.querySelector('.hamburger-navigation');
        if (hamburgerNav && !hamburgerNav.querySelector('.mobile-search-trigger')) {
            var mobileSearchBtn = document.createElement('a');
            mobileSearchBtn.href = '#';
            mobileSearchBtn.className = 'mobile-search-trigger h-[30px] w-[30px] bg-primary text-white rounded-full flex justify-center items-center';
            mobileSearchBtn.setAttribute('title', 'Zoeken');
            mobileSearchBtn.innerHTML = '<i class="fa-solid fa-search" style="pointer-events:none;font-size:12px;"></i>';
            mobileSearchBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // Close mobile menu if open
                var mobileCheckbox = document.getElementById('nav-mobile-active');
                if (mobileCheckbox && mobileCheckbox.checked) {
                    mobileCheckbox.checked = false;
                    mobileCheckbox.dispatchEvent(new Event('change'));
                }
                if (typeof window.wefabricToggleSearch === 'function') {
                    window.wefabricToggleSearch();
                }
            });
            // Insert before the hamburger toggle label
            var hamburgerLabel = hamburgerNav.querySelector('.hamburger-button');
            if (hamburgerLabel) {
                hamburgerNav.insertBefore(mobileSearchBtn, hamburgerLabel);
            } else {
                hamburgerNav.appendChild(mobileSearchBtn);
            }
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMainNavSearch);
    } else {
        initMainNavSearch();
    }
})();
</script>
