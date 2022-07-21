@php
    $hx = 'h'. ($type ?? '3');
@endphp

<div class="container flex">
    <{{$hx}} @if($id ?? '') id="{{ $id }}" @endif
        class="font-head inline-block align-text-top z-10 {{ $class ?? 'text-black'  }}">
        {!! $heading !!}
    </{{$hx}}>
</div>
