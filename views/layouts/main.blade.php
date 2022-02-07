@php
    $options = get_fields('option');
@endphp

        <!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @head
    @if(isset($options['header_codes']) && $options['header_codes'])
        {!! $options['header_codes'] !!}
    @endif
</head>
<body @php(body_class())>
@if(isset($options['body_codes']) && $options['body_codes'])
    {!! $options['body_codes'] !!}
@endif
@if(isset($options['out_of_office']['active']) && $options['out_of_office']['active'])
    @if((isset($options['out_of_office']['start_display_date']) && $options['out_of_office']['start_display_date'] <= date('Ymd')) || $options['out_of_office']['start_display_date'])
        @if((isset($options['out_of_office']['end_display_date']) && $options['out_of_office']['end_display_date'] >= date('Ymd')) || $options['out_of_office']['end_display_date'])
            @include('components.out-of-office', ['outOfOffice' => $options['out_of_office']])
        @endif
    @endif
@endif
<div id="page" class="site">
    @include('components.navigation.header-top')
    <header id="masthead" class="px-4">
        <div class="flex flex-row container mx-auto">
            <div class="hidden lg:block w-1/6 items-center">
                @include('components.header.logo')
            </div>
            <div class="lg:w-5/6 lg:flex items-center justify-end h-12 lg:h-auto">
                @include('components.navigation.main-nav')
                @include('components.navigation.header-mobile')
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
        @include('components.footer.footer')
    </footer><!-- #colophon -->
</div><!-- #page -->

@footer

</body>
</html>
