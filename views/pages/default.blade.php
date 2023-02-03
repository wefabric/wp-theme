@extends('layouts.main')

@section('content')
    @loop
        <div class="header">
            {!! themeHeader()->render() !!}
        </div>

    		@if(!is_front_page())
    			@include('components.subbanner.nxtsubheader', ['classes' => ''])
    		@endif

        <div class="page-builder">
            {!! pageBuilder()->render() !!}
        </div>
    @endloop
@endsection
