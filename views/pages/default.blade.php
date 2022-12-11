@extends('layouts.main')

@section('content')
    @loop


        @if(get_the_ID() !== wc_get_page_id( 'cart' ))
            @if(get_post_type() === 'post' && themeHeader()->getHeaderValues(get_the_ID())->count() === 0)
                <div class="header">
                    {!! (new \App\Helpers\Post())->renderDefaultHeader(get_post()) !!}
                </div>
            @else
                <div class="header">
                    {!! themeHeader()->render() !!}
                </div>
            @endif

        @endif

		@if(!is_front_page() && get_the_ID() !== wc_get_page_id( 'cart' ))
			@include('components.breadcrumbs.index', ['classes' => ''])
		@endif

        <div class="page-builder">
            {!! pageBuilder()->render() !!}
        </div>
    @endloop
@endsection