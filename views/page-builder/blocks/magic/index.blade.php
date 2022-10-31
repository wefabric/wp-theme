{{--
	This block is intended to be used only in development. When a block cannot be (yet) developed, use this block to create a sort of placeholder so that the design as a whole can be checked.

	ACF structure:
		- name = 'magic'
		
	Block:
		- name = 'magic_block'
		- type = 'selector'
		- required = yes

--}}

@php
	$value = $block->get('magic_block')
@endphp

<div class="">
	@if(false)
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
		@case('Test')
			<div class="bg-gray-100 py-8 lg:py-24">
				<div class="h4 text-center pb-10">Test</div>
				
				{{-- Insert the rest of the design here. --}}
			</div>
			@break

		@default
			<div class="py-8 lg:py-24 h4 text-center text-red-500"> Value {{ $value['value'] }} is not supported!</div>
	@endswitch
	
</div>