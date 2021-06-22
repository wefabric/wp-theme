@php
  $imageId = $block->get('image') ? $block->get('image') : get_field('common', 'option')['default_header_image'];
@endphp
<div class="header-1 w-full" style="background: url('{{wp_get_attachment_image_url($imageId, 'full')}}')">
    <div class="container mx-auto px-4 lg:px-0 py-20 xl:py-40">
        <h1 class="text-white text-shadow-lg text-center lg:text-left text-4xl xl:text-6xl mx-a lg:w-3/4 xl:w-1/2">
            {{ $block->get('title') }}
        </h1>
        @if($block->get('button_1') || $block->get('button_2'))
            <div class="lg:flex lg:flex-row  mt-8 text-center lg:text-left">

                @if($block->get('button_1'))
                    <div class="mb-8 lg:mb-0">
                        @include('components.buttons.default', ['classes' => 'text-shadow-lg shadow-lg btn-white bg-secondary border-0 lg:bg-transparent lg:border-2', 'button' => $block->get('button_1')] )
                    </div>
                @endif
                @if($block->get('button_2'))
                    <div>
                        @include('components.buttons.default', ['classes' => 'text-shadow-lg lg:hidden border-b-2 border-transparent hover:border-white border-t-0 border-r-0 border-l-0 leading-8 disable-chevron text-white', 'button' => $block->get('button_2')])
                        @include('components.buttons.default', ['classes' => 'text-shadow-lg hidden lg:inline-block lg:border-none btn-transparent text-white lg:ml-8', 'button' => $block->get('button_2')])
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>