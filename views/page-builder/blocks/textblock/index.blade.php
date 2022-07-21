<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
    @include('components.content', ['content' => apply_filters('the_content', $block->get('text'))])
</div>
