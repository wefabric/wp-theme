@php
    $options = get_fields('option');
@endphp

        <!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <link rel="profile" href="https://gmpg.org/xfn/11">
    @head
    @if(isset($options['header_codes']) && $options['header_codes'])
        {!! $options['header_codes'] !!}
    @endif
</head>
<body @php(body_class())>
@if(isset($options['body_codes']) && $options['body_codes'])
    {!! $options['body_codes'] !!}
@endif
<div id="page" class="site">
    @if(isset($options['show_menu']) && $options['show_menu'])

        <header id="masthead">
            @if (isset($options['show_secondary_menu']) && $options['show_secondary_menu'])
               @include('components.navigation.secondary-nav')
            @endif
            <div class="main-navigation main-navigation-bar bg-{{ $options['menu_background_color'] }} text-{{ $options['menu_text_color'] ?? 'white' }}">
                <div class="nav-container flex flex-row container mx-auto py-3 px-4 md:px-8">
                    <div class="logo hidden xl:flex w-1/6 items-center">
                        @include('components.header.logo')
                    </div>
                    <div class="xl:w-5/6 flex items-center justify-end h-16 xl:h-auto">
                        @include('components.navigation.main-nav')
                        @include('components.navigation.header-mobile')
                    </div>
                </div>
            </div>
        </header>
    @endif

    <div id="content" class="">
        <div id="primary">
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div><!-- #content -->
    <footer id="colophon" class="site-footer">
        @include('components.footer.footer')
    </footer><!-- #colophon -->
</div><!-- #page -->

@footer

{!! styleCustomizer()->renderCustomColors() !!}

@if(isset($options['footer_codes']) && $options['footer_codes'])
    {!! $options['footer_codes'] !!}
@endif
</body>
</html>