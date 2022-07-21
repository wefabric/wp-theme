<div class="container mx-auto {{ $class ?? '' }}">
    @if(!empty($title))
        @include('components.headings.normal', [
            'type' => '2',
            'class' => 'font-bold text-2xl py-2',
            'heading' => $title,
        ])
    @endif

    @if(!empty($subtitle))
        <div class="font-bold text-xl py-4">
            {{ $block->get('subtitle') }}
        </div>
    @endif

    <div class="grid grid-cols-{{ $col_amount }}">
        @foreach($usps as $usp)
            <div class="text-xl font-bold {{ $usp['icon'] }} " style="color: {{ $block->get('icon_color') }};">
                @php
                    if(!empty($usp['external_url'])) {
                        $link = $usp['external_url'];
                    } elseif (!empty($usp['page_url'])) {
                        $link = $usp['page_url'];
                    }

					$font = 'font-sans font-medium text-black text-sm lg:text-base';
                @endphp

                @if(! empty($link))
                    @include('components.link.simple', [
                        'href' => $link,
                        'text' => $usp['title'],
                        'class' => $font,
                    ])
                @else
                    <span class="{{ $font }}">
                        {{ $usp['title'] }}
                    </span>
                @endif

            </div>
        @endforeach
    </div>
</div>
