@php
    $options = get_fields('option');
@endphp

        <!doctype html>
<html {!! get_language_attributes() !!}>
<head>
    <meta charset="{{ get_bloginfo('charset') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
@if(isset($options['out_of_office']['active']) && $options['out_of_office']['active'])
    @if(empty($options['out_of_office']['start_display_date']) || $options['out_of_office']['start_display_date'] <= date('Ymd'))
        @if(empty($options['out_of_office']['end_display_date']) || $options['out_of_office']['end_display_date'] >= date('Ymd'))
            @include('components.out-of-office', ['outOfOffice' => $options['out_of_office']])
        @endif
    @endif
@endif

<div id="page" class="site">

  @include('components.header.nxtheader')

  <div id="content">
      <div id="primary">
          <main id="main">
              @yield('content')
          </main>
      </div>
  </div>

  @include('components.program.nxtprogram')

  @include('components.register.nxtregister')

  @include('components.sponsoren.nxtsponsoren')

{{--



  @include('components.subbanner.nxtsubbanner')

  @include('components.inschrijven.nxtinschrijven')

  @include('components.banner.nxtbanner')

  @include('components.gallerij.nxtgallerij')

  @include('components.program.nxtprogram')

  @include('components.speakers.nxtspeakers')

  @include('components.speakers-overview.nxtspeakers-overview')

  @include('components.register.nxtregister')

  @include('components.sponsoren.nxtsponsoren')

--}}

  @include('components.cta.nxtcta')

  @include('components.referenties.nxtreferenties')

  @include('components.footer.nxtfooter')

</div>

@footer

{!! styleCustomizer()->renderCustomColors() !!}

</body>
</html>
