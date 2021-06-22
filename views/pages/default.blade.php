@extends('layouts.main')

@section('content')
    @loop
        <div class="header">
            {!! themeHeader()->render() !!}
        </div>
        <div class="page-builder">
            {!! pageBuilder()->render() !!}
        </div>
    @endloop
@endsection