<div class="container px-4 lg:px-0 mx-auto xl:w-1/2">
    @include('components.content', ['content' => apply_filters('the_content', $block->get('text'))])
</div>
