@extends('layouts.main')

@section('content')
    @loop
        <div class="header">
            {!! themeHeader()->render() !!}
        </div>

		@if(!is_front_page())
			<div class="container mx-auto px-8 lg:px-0">
				@include('components.breadcrumbs.index', ['classes' => ''])
			</div>
		@endif
	
        <div class="page-builder">
            {!! pageBuilder()->render() !!}
        </div>
    @endloop
@endsection