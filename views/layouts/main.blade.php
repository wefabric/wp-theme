<!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @head
</head>
<body @php(body_class())>
<div id="page" class="site">
    <header id="masthead" class="bg-primary px-4 py-8">
        <div class="flex flex-row">
            <div class="w-1/6">
                @include('components.header.logo')
            </div>
            <div class="w-5/6">
                @include('components.navigation.main-nav')
            </div>
        </div>
    </header>

    <div id="content">
        <div id="primary">
            <main id="main">
                @yield('content')
            </main>
        </div>
    </div><!-- #content -->

    <footer id="colophon" class="site-footer">
        <div class="site-info">
            <span class="sep"> ©{{ (new DateTime())->format('Y') }} {{ get_bloginfo('name') }} | </span>
            {!! sprintf(esc_html__('Ontwikkeld door %1$s .', THEME_TD), '<a href="https://wefabric.nl">Wefabric</a>') !!}
        </div><!-- .site-info -->
    </footer><!-- #colophon -->
</div><!-- #page -->

@footer

</body>
</html>
