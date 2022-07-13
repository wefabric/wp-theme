<div class="mx-auto lg:{{ $block->get('width') }}">
    @include('components.content', ['content' => apply_filters('the_content', $block->get('text'))])
</div>
