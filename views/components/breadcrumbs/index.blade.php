<div class="w-full {{ $bg_color ?? 'bg-black text-white' }} py-10">
	<div class="container mx-auto px-8 lg:px-24">
		<div class="flex mx-auto text-base {{ $classes ?? 'w-4/5 lg:w-3/5' }}">

{{--
			@include('components.link.opening', [
				'href' => get_home_url(),
				'alt' => 'Homepagina',
				'class' => 'self-center mr-1',
			])
				<i class="fa-solid fa-house mr-4"></i>
			@include('components.link.closing')
--}}
			
			<div>
				{!! yoast_breadcrumb() !!}
			</div>
		</div>
	</div>
</div>
