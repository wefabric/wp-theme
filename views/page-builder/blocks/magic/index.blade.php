{{--
	This block is intended to be used only in development. When a block cannot be (yet) developed, use this block to create a sort of placeholder so that the design as a whole can be checked.
--}}

@php
	$value = $block->get('magic_block')
@endphp

<div class="">
	@if(true)
		<div class="h2 w-full text-center">
			<span class="text-purple-500">T</span>
			<span class="text-blue-500">O</span>
			<span class="text-yellow-500">V</span>
			<span class="text-red-500">E</span>
			<span class="text-green-500">R</span>
			<span class="text-purple-500">B</span>
			<span class="text-blue-500">L</span>
			<span class="text-yellow-500">O</span>
			<span class="text-red-500">K</span>
			<span class="text-green-500">!</span>
			<i class="fa-regular fa-face-smile-beam text-amber-900"></i>
		</div>
	@endif
	
	@switch($value['value'])
		@case('products')
			<div class="bg-gray-100">
				<div class="h6 text-center pb-10">Uitgelichte producten</div>
				
				@php
					$products = [
						[
							'brand' => 'ENPC',
							'title' => 'Geribd hoekijzer met afgesneden hoek',
							'price' => 1394,
							'image' => 832,
						],
						[
							'brand' => 'ENPC',
							'title' => 'Bevestigingsklauw voor warmte-isolatie',
							'price' => 1394,
							'image' => 833,
						],
						[
							'brand' => 'ENPC',
							'title' => 'Heel duur stuk staal met gaatjes',
							'price' => 1394,
							'image' => 834,
						],
						[
							'brand' => 'ENPC',
							'title' => 'Anti-inbreekijzer denk ik?',
							'price' => 1394,
							'image' => 835,
						],
					];
				@endphp
				@include('components.slider.smart-slider', [
					'items' => $products,
					'card_type' => 'product',
					'arrows' => true,
				])
			</div>
			@break
		
		@case('categories')
			<div class="flex flex-col justify-center">
				<div class="h6 text-center pb-10">Uitgelichte categorieen</div>
				
				@php
					$categories = [
						[
							'title' => 'Draadnagels',
							'image' => '1435',
						],
						[
							'title' => 'Nagelkaas',
							'image' => '1434',
						],
						[
							'title' => 'Spijkers',
							'image' => '1433',
						],
					];
				@endphp
				@include('components.slider.grid', [
					'items' => $categories,
					'card_type' => 'category',
					'grid_spacing' => 'md:gap-12'
				])
				
				@include('components.buttons.default', [
					'href' => '#',
					'text' => 'Alles producten',
					'a_class' => 'mx-auto pt-12',
					'colors' => 'bg-black text-white',
				])
			</div>
			@break
		
		@case('feedbackco')
			<div class="bg-gray-100">
				<div class="h6 text-center pb-10">
					Feedback Company reviews
					<p class="italic text-sm">Dit zijn afbeeldingen, aangezien we mogelijk een widget uit FeedbackCo. halen?</p>
				</div>
				@php
					$reviews = [
						[
							'file' => 'review-1.png'
						],
						[
							'file' => 'review-2.png'
						],
						[
							'file' => 'review-3.png'
						],
					];
				@endphp
				@include('components.slider.smart-slider', [
					'items'	=> $reviews,
					'card_type' => 'customer-review',
				])
				
			</div>
			@break
		
		@case('brand-documentation')
			<div class="">
				<div class="h6 text-center pb-10">Merk documentatie</div>
				@php
					$brand = [
						'title' => 'INDEX Fixing Systems',
						'image' => 1423,
						'description' => 'KreQ biedt u de industriële bevestigingssystemen van INDEX Fixing Systems. INDEX levert totaaloplossingen aangepast aan de behoeften van de klant. De producten van INDEX Fixing Systems worden door onafhankelijke laboratoria gekeurd en gecertificeerd en staan daarom garant voor kwaliteit.',
						'files' => [
							[
								'type' => 'catalogus',
								'name' => 'Catalogus 2021',
								'image' => '1430',
								'file' => '1429',
							],
							[
								'type' => 'de gids',
								'name' => 'Constructie-houtschroeven',
								'image' => '',
								'file' => '',
							],
							[
								'type' => 'flyer',
								'name' => 'Brandwerendheid verbinders',
								'image' => '',
								'file' => '',
							],
							[
								'type' => 'catalogus',
								'name' => 'Catalogus 2021',
								'image' => '',
								'file' => '',
							],
						],
					];
				@endphp
				@include('components.brand-documentation.index', [
					'brand' => $brand,
					'bg_color' => 'bg-gray-100',
				])
			</div>
			@break
		
		@default
			<div class="h6 text-center text-red-500"> Value {{ $value['value'] }} is not supported!</div>
	@endswitch
	
</div>