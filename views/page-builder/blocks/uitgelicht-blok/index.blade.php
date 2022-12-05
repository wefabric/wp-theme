@php
    $left = $block->get('information_left');
    $right = $block->get('information_right');
@endphp

<div class="grid grid-cols-2 gap-4">
    <div>
        <h2>{{ $left->get('title') }}</h2>

        @include('components.content', [
            'content' => $left->get('text')
        ])

        @include('components.link.simple', [
		    'href' => $left->get('url'),
		    'text' => $left->get('link_text'),
		    'class' => 'btn btn-primary text-white',
        ])
    </div>

    <div>
        <div>
            <p class="font-bold">Datum</p>
            <p>{{ $right->get('date') }}</p>
        </div>

        <div>
            <p class="font-bold">Tijd</p>
            <p>{{ $right->get('time') }}</p>
        </div>

        <div>
            <p class="font-bold">Locatie</p>
            <p>{{ $right->get('location') }}</p>
        </div>

    </div>
</div>
