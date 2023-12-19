<input type="checkbox" class="hidden" id="nav-mobile-active">

<div class="logo-mobile float-left xl:hidden z-10 relative">
    <div class="site-title">
        <a href="{{ esc_url( home_url('/')) }}" class="block" aria-label="home" rel="home">
            @if(isset(get_field('common', 'option')['logo']) && $logoId = get_field('common', 'option')['logo'])
                {!! wp_get_attachment_image( $logoId , 'full', false, ['class' => 'max-h-12 w-auto']) !!}
            @endif
        </a>
    </div>
</div>

<label for="nav-mobile-active" class="nav-mobile-toggle-visibility nav-mobile-toggler nav-mobile-overlay z-0"></label>
<header class="banner absolute left-0 w-full">
    <div>
        <div class="py-2 pr-16 flex items-center justify-end relative xl:hidden">

            <div class="hamburger-menu z-50">
                <label for="nav-mobile-active"
                       class="mb-0 toggle-mobile-menu hamburger-button inline-block align-bottom ">
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                    <span class="hamburger-button-bar"></span>
                </label>
            </div>

        </div>
        <div class="block xl:hidden mobile-menu-wrap">
            <nav class="mobile-menu">
                <div class="mobile-logo">
                    @include('components.header.logo', ['type' => 'white'])
                </div>

                <nav id="site-navigation" class="main-navigation">
                    {!! wp_nav_menu([
                        'theme_location' => 'menu-1',
                        'menu_id' => 'primary-menu',
                        'echo' => false
                    ]) !!}
                </nav>
            </nav>
        </div>

    </div>
</header>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var menuItems = document.querySelectorAll('.menu-item-has-children');
        menuItems.forEach(function (item) {
            var link = item.querySelector('a');
            item.addEventListener('click', function (event) {
                if (event.target === link) { //if the click is on the link, navigate
                    location.href = link.href;
                } else { //otherwise toggle the class
                    item.classList.toggle('open');
                }
            });
        });
    });
</script>
