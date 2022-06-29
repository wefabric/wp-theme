<div class="container mx-auto lg:{{ $block->get('width') }} ">
    @if(!empty($block['image']))
        @include('components.image', ['image_id' => $block->get('image')])
    @endif
</div>
