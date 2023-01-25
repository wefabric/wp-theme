<div>
    <div class="grid grid-cols-2 gap-4">
        <div>
            @include('components.image', [
                'image_id' => $block->get('image')
            ])
        </div>

        <div>
            <div>
                <p class="font-bold">Tijd</p>
                <p>{{ $block->get('time') }}</p>
            </div>

            @include('components.content', [
                'content' => $block->get('description'),
            ])

            @include('components.link.simple', [
                'href' => $block->get('url'),
                'text' => $block->get('link_text'),
                'class' => 'btn btn-primary text-white',
            ])
        </div>
    </div>
</div>
