@extends('layouts.main')

@section('content')
    @loop
        <div class="page-builder">
            {!! the_content() !!}
        </div>
    @endloop
@endsection