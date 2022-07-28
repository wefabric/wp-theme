@php
    $imageId = $block->get('image') ?? get_field('common', 'option')['default_header_image'];
@endphp

<div class="header-1 w-full bg-gradient-to-b from-white to-black">
    <div class="mx-4 lg:mx-20 py-15 lg:py-40  bg-center bg-cover bg-no-repeat rounded-lg z-50" style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}')">
        <div class="container mx-auto w-full lg:w-3/4 text-center ">
            <h1 class="">
                {{ $block->get('title') }}
            </h1>

            @if(!empty($block->get('subtitle')))
                <h2 class="pt-4 lg:pt-11">
                    {{ $block->get('subtitle') }}
                </h2>
            @endif

            @if(!empty($block->get('call_to_actions')))
                <div class="flex flex-col lg:flex-row justify-center pt-4 lg:pt-7">
                    @foreach($block->get('call_to_actions') as $cta)
                        @if($cta->get('type') === 'button')
                            @include('components.buttons.default', [
                                'href' => $cta->get('link'),
                                'text' => $cta->get('text'),
                                'colors' => 'btn-white text-black'
                            ])
                        @elseif($cta->get('type') === 'link')
                            @include('components.buttons.default', [
                                'href' => $cta->get('link'),
                                'text' => $cta->get('text'),
                                'colors' => 'btn-transparent text-white'
                            ])
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
