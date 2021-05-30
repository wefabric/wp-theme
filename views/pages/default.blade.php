@extends('layouts.main')

@section('content')
    @loop
        <div class="content">
            {!! pageBuilder()->render() !!}
        </div>
    @endloop
@endsection