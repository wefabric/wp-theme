<div class="block">
    @php
        switch($position) {
            case 'above':
                $flexDir = 'flex-col';
                break;
            case 'left':
                $flexDir = 'flex-row';
                break;
            default:
                $flexDir = '';
        }

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

        <div class="flex {{ $flexDir }} items-center">
            <div class="text-{{ $size }} {{ $item->get('icon') }} pr-4 text-{{ $icon_color ?? 'black' }}"></div>

            <div class="flex flex-col">
                @if(!empty($item->get('title')))
                    <span class="block text-xl font-bold">
                        {{ $item->get('title') }}
                    </span>
                @endif

                @if(!empty($item->get('subtitle')))
                    <span class="block text-base font-normal">
                        {{ $item->get('subtitle') }}
                    </span>
                @endif
            </div>
        </div>

    @if(! empty($link))
        @include('components.link.closing')
    @endif
</div>
