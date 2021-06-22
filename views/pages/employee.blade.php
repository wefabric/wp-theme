@extends('layouts.main')

@section('content')
    @loop
    <div class="header">
        {!! themeHeader()->render() !!}
    </div>

    {{ get_field('function') }}

    <div class="page-builder">
        {!! pageBuilder()->render() !!}
    </div>
    @endloop
@endsection