<div class="{{ $bg_color ?? 'bg-white' }}">
	<div class="lg:px-28">
		@include('components.headings.normal', [
			'type' => 'h2',
			'heading' => $brand['title'],
		])
	
		<div class="grid lg:flex md:gap-16 pb-4 lg:pb-12">
			<div class="lg:flex-autogrow rounded-lg p-4 bg-white shadow-lg"> {{-- border border-gray-300 --}}
				@include('components.image', [
					'image_id' => $brand['image'],
					'size' => 'brand_logo',
				])
			</div>
			
			<div class="pt-4 md:pl-12">
				@include('components.content', [
					'content' => $brand['description'],
				])
			</div>
		</div>
	</div>
	
	@include('components.slider.smart-slider', [
		'items' => $brand['files'],
		'card_type' => 'brand-file',
		'arrows' => true,
//		'dots' => false,
		'' //gap 70
		
	])
	
</div>