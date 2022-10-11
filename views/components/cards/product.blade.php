@php
	if(!isset($product)) {
		$product = $item;
	}
@endphp

<div class="card flex flex-col p-5 pb-32 bg-white  relative min-h-[488px] lg:min-h-[465px]"> {{-- max-w-[310px] --}}
	@include('components.image', [
		'image_id' => $item['image'],
		'size' => 'product_card',
		'class' => ' mx-auto h-[225px]',
		'img_class' => 'bg-center bg-no-repeat',
	])
	
	<div class="card-category-title w-full">
		{{ $product['brand'] }}
	</div>
	
	<div class="h5 py-2">
		{{ $product['title'] }}
	</div>
	
	<div class="absolute bottom-0 flex flex-col w-full pt-2.5 pb-5">
		<div class="h5 text-primary-dark pb-6">
			€ {{ $product['price'] }},-
		</div>

		<div class="flex flex-row">
			@include('components.buttons.default', [
				'href' => '#',
				'text' => 'Meer info',
				'colors' => 'btn-black text-white'
			])
			
			<div class="flex grow"></div> {{-- TODO fix below so this isn't required. --}}
			
			@include('components.buttons.icon', [
				'href' => '#',
				'alt' => 'Voeg toe aan winkelwagen',
				'a_class' => '', //TODO fix this with e.g. 'justify-self-end'
				'size' => 'h-12 w-12 pt-1.5 mr-9',
				'icon' => 'fa-solid fa-cart-shopping text-xl',
				'colors' => 'bg-green-600 text-white'
			])
		</div>
	</div>
	
</div>