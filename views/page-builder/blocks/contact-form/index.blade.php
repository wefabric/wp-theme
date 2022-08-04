<div class="container mx-auto w-full lg:{{ $block->get('width') }} bg-{{ $block->get('bg_color') }} text-{{ $block->get('text_color') }}  pt-4 lg:pt-8">

    <div class="bg-{{ $block->get('fill_color') }} lg:p-16 lg:pr-64 relative ">

        @if($block->get('title'))
            @include('components.headings.normal', [
                'type' => 3,
                'title' => $block->get('title'),
                'text_color' => $block->get('text_color'),
            ])
        @endif

        <div class="mt-3">
            {!! $block->get('form') !!}
        </div>

        <div class="">
            By sending this form, you’ve red and agreed with our privacy policy.
        </div>

        <div class="absolute ">
            @include('components.image', [
	            'image_id' => $block->get('image')->get('image'),
	            'size' => '', // 250x200

            ])
        </div>

    </div>

</div>