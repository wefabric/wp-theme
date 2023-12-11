<div class="container mx-auto w-full flex justify-{{ $block->get('position') }}">
    @include('components.buttons.default', [
        'button' => $block,
    ])
</div>
