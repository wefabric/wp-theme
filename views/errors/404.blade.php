@extends('layouts.main')

@section('content')
    <header class="page-header py-24 bg-primary mb-9">
        <h1 class="page-title px-8 text-center text-white">{!! esc_html__('Oeps! Deze pagina werd niet gevonden.', THEME_TD) !!}</h1>
    </header><!-- .page-header -->
    <section class="error-404 not-found container mx-auto py-9 px-8">
        <div class="page-content">
            <p>{{ esc_html__('Het lijkt erop dat deze pagina niet (meer) bestaat. Controleer of je de pagina correct hebt geschreven of gebruik het menu om te vinden wat je zoekt.', THEME_TD) }}</p>
        </div>
    </section>
@endsection