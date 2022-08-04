{{-- MARKED FOR DELETION. Use cards.usp --}}

<div class="block">

    @php
        if(!empty($item->get('external_url'))) {
            $link = $item->get('external_url');
        } elseif (!empty($item->get('page_url'))) {
            $link = $item->get('page_url');
        }
    @endphp

    @if(! empty($link))
        @include('components.link.opening', [
            'href' => $link,
            'alt' => $item->get('title'),
        ])
    @endif

    <div class="text-6xl {{ $item->get('icon') }} " style="color: {{ $block->get('icon_color') }};"></div>

    <div>
        <span class="block text-xl font-bold">
            {{ $item->get('title') }}
        </span>

        <span class="block text-base font-normal">
            {{ $item->get('subtitle') }}
        </span>
    </div>

    @if(! empty($link))
        @include('components.link.closing')
    @endif

</div>