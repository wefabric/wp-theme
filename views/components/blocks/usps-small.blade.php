{{-- MARKED FOR DELETION. Use pagebuilder.blocks.usps --}}

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

    <div class="flex flex-row justify-center">
        @foreach($usps as $usp)
            <div class="w-1/{{$col_amount}} text-xl flex justify-center items-center font-bold {{ $usp['icon'] }} text-{{ isset($block) ? $block->get('icon_color') : $usp['color'] }} ">
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
                        'class' => $font .' pl-2',
                    ])
                @else
                    <span class="{{ $font }} pl-2">
                        {{ $usp['title'] }}
                    </span>
                @endif

            </div>
        @endforeach
    </div>
</div>
