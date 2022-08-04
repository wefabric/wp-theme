{{-- MARKED FOR DELETION. Use pagebuilder.blocks.gallery with 1 image. --}}

<div class="container mx-auto w-full lg:{{ $block->get('width') }} ">
    @if(!empty($block['image']))
        @include('components.image', ['image_id' => $block->get('image')])
    @endif
</div>
