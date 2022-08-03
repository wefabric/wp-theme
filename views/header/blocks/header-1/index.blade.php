@php
    $imageId = $block->get('image') ?? get_field('common', 'option')['default_header_image'];

    $from = 'rgba(255,255,255,255)'; //white
    $to = 'rgba(0,0,0,255)'; //black
    $gradient = 'background: linear-gradient(180deg, '. $from .' 0%, '. $from .' 50%, '. $to .' 50%, '. $to .' 100%);';

    $gradient = ''; //ignore here
@endphp

    <div class="mx-4 lg:mx-20 py-15 lg:py-40  bg-center bg-cover bg-no-repeat rounded-lg z-50" style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}')">
<div class="header-1 w-full" style="{{ $gradient }}">
        <div class="container mx-auto w-full lg:w-3/4 flex flex-col items-center text-center text-{{ $block->get('text_color') }}">
            <h1 class="w-1/2 text-[58px]">
                {{ $block->get('title') }}
            </h1>

            @if(!empty($block->get('subtitle')))
                <h2 class="pt-4 lg:pt-11">
                    {{ $block->get('subtitle') }}
                </h2>
            @endif

            @if(!empty($block->get('call_to_actions')))
                @php
                    $classes = 'text-white text-lg';
                @endphp

                <div class="flex flex-col lg:flex-row justify-center pt-4 lg:pt-7">
                    @foreach($block->get('call_to_actions') as $item)
                        @php
                            $cta = $item->get('cta');
                        @endphp

                        @if($cta->get('type') === 'button')
                            @include('components.buttons.default', [
	                            'button' => $cta,
                                'class' => 'disable-chevron'
                            ])
                        @elseif($cta->get('type') === 'link')
                            @include('components.buttons.default', [
	                            'button' => $cta,
                                'class' => 'btn-transparent disable-chevron'
                            ])
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
