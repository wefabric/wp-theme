<div class="flex">
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
            <div class="">
                @if(!empty($item->get('image')))
                    @include('components.image', [
	                    'image_id' => $item->get('image'),
	                    'size' => 'usp-icon',
                    ])
                @elseif(!empty($item->get('icon')))
                    <span class="text-{{ $size }} {{ $item->get('icon') }} text-{{ $icon_color ?? 'black' }}"></span>
                @endif
            </div>

            <div class="flex flex-col px-5">
                <span class="block text-base font-normal">
                    {{ $item->get('title') }}
                </span>
            </div>
        </div>

    @if(! empty($link))
        @include('components.link.closing')
    @endif
</div>
