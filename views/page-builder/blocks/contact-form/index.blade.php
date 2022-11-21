@php
    $options = get_fields('option');

	/*
    if($block->get('image') && $block->get('image')->get('position')) {
        //then what?
    }
	*/

	$info = $block->get('show_information')

@endphp
<div class="@if(empty($info->get('display_type'))) bg-{{ $block->get('bg_color') }} text-{{ $block->get('text_color') }} @endif">

    <div class="position-relative z-index-2 mx-auto">
		@if($block->get('title')->get('show_separate_title'))
			@include('components.headings.collection', [
				'title' => $block->get('title'),
			])
		@endif

		<div class="relative @if(!empty($info->get('display_type'))) md:grid md:grid-cols-2 gap-24 @endif" >

            <div class="bg-{{ str_replace('-color', '', $block->get('background_color', '')) }} rounded-lg  text-{{ $block->get('text_color') }} -mt-2
	            @if(empty($info->get('display_type')))
	            	w-full lg:{{ $block->get('width_form') }}
	            	@if($block->get('fill_color')) bg-{{ $block->get('fill_color') }} p-12 @endif
				@endif
				@if($info->get('info_position') === 'left') order-2 @endif ">

				<div class="form">
	                {!! $block->get('form') !!}
				</div>
			</div>

            @if(!empty($info->get('display_type')))
				<div class="@if($info->get('info_position') === 'left') order-1 pt-8 lg:pt-0 @else pb-8 lg:pb-0 @endif">
					@if($info->get('display_type') === 'column')
						@include('page-builder.blocks.contact-form.address', [
							'establishment_id' => $block->get('establishment'),
						])
					@elseif($info->get('display_type') === 'textbox')
						{!! $info->get('info') !!}
						<div class="mt-4">
							@include('page-builder.blocks.contact-form.address', [
                                'establishment_id' => $block->get('establishment'),
                                'show_title' => false
                            ])
						</div>
					@endif
					@include('components.contact.employees')
				</div>
            @endif

			@if(false)
				<div class="offset-md-1 mt-12 md:mt-0 col-md-4 text-base">
				</div>
			@endif
		</div>


		@if($block->get('image') && $block->get('image')->get('image'))
			<div class="absolute -right-2 md:-right-6 md:-bottom-16">
				@include('components.image', [
					'image_id' => $block->get('image')->get('image'),
					'size' => 'full',
					'class' => 'rounded-lg max-w-[150px] lg:max-w-none',
				])
			</div>
		@endif

	</div>

</div>