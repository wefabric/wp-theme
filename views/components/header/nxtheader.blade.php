<header id="masthead" class="">
    <div class="flex flex-row container mx-auto">

      <div class="w-3/12 flex items-center px-4">
          @include('components.header.logo')
      </div>

      <div class="w-6/12 flex items-center justify-end lg:h-auto">
          <nav id="site-navigation" class="main-navigation flex justify-end items-center">
            <ul class="menu">
              @php wp_nav_menu( array('menu' => 'Main', 'container' => '', 'items_wrap' => '%3$s' )); @endphp
            </ul>
          </nav>
      </div>

      <div class="w-3/12 flex items-center justify-center relative brick">
        <span class="flex items-center justify-center text-center register">
          <a href="{{ esc_url(home_url('/inschrijven')) }}" title="Registreren" class="">Inschrijven</a>
        </span>

        <div class="hamburger" id="hamburger-6">
          <span class="line"></span>
          <span class="line"></span>
          <span class="line"></span>
        </div>

      </div>

    </div>
</header>
