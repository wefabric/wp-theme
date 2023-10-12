@php
    $pageTitle = $page['title'] ?? '';
    $pageUrl = $page['url'] ?? '';
@endphp

<a href="{{ $pageUrl }}" class="">
    <div class="cardbackground bg-primary aspect-square h-[100px] w-full ease-in-out duration-300 transform-all">
        {{ $pageTitle }}
    </div>
</a>