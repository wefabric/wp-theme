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
        <header id="masthead" class="px-4 bg-{{ $options['menu_background_color'] ?? 'primary-color-dark' }} text-{{ $options['menu_text_color'] ?? 'white' }}">
            <div class="flex flex-row container mx-auto py-4">
                <div class="hidden lg:block w-1/6 items-center">
                    @include('components.header.logo')
                </div>
                <div class="lg:w-5/6 lg:flex items-center justify-end h-16 lg:h-auto">
                    @include('components.navigation.main-nav')
                    @include('components.navigation.header-mobile')
                </div>
            </div>
        </header>
    @endif

    <div id="content" class=" -mt-4">
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

</body>
</html>