@foreach($usps as $usp)
    @include('components.usps.list-item', ['usp' => $usp])
@endforeach