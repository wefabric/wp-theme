{{-- MARKED FOR DELETION. Use pagebuilder.blocks.usps --}}

@include('components.blocks.usps-large', [
    'title' => $block->get('title'),
    'subtitle' => $block->get('subtitle'),
    'usps' => $block->get('usps')
])
@if(!empty($block->get('button_text')) && (!empty($block->get('button_external_link')) || !empty($block->get('button_internal_link'))))
    <div class="pt-4 lg:pt-10 flex justify-center">
        @include('components.buttons.default', [
            'href' => $block->get('button_external_link') ?? $block->get('button_internal_link'),
            'text' => $block->get('button_text'),
        ])
    </div>
@endif
