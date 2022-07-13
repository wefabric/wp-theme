<div class="">
    <div class="font-bold text-2xl py-2">
        {{ $block->get('title') }}
    </div>

    <div class="font-bold text-xl py-4">
        {{ $block->get('subtitle') }}
    </div>

    <div class="grid grid-cols-{{ $block->get('col_amount') }}">
        @foreach($block->get('usps') as $usp)
            <div class="text-xl font-bold {{ $usp->get('icon') }} " style="color: {{ $block->get('icon_color') }};">
                @php
                    if(!empty($usp->get('external_url'))) {
                        $link = $usp->get('external_url');
                    } elseif (!empty($usp->get('page_url'))) {
                        $link = $usp->get('page_url');
                    }

					$font = 'font-sans font-medium text-black text-sm lg:text-base';
                @endphp

                @if(! empty($link))
                    @include('components.link.link-text', [
                        'href' => $link,
                        'text' => $usp->get('title'),
                        'class' => $font,
                    ])
                @else
                    <span class="{{ $font }}">
                        {{ $usp->get('title') }}
                    </span>
                @endif

            </div>
        @endforeach
    </div>
</div>
