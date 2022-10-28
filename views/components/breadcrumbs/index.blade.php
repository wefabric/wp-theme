<div class="w-full {{ $bg_color ?? 'bg-black text-white' }} py-10">
	<div class="container mx-auto px-8 lg:px-24">
		<div class="flex mx-auto text-base {{ $classes ?? 'w-4/5 lg:w-3/5' }}">

			<div>
				@php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); @endphp
				@php if (function_exists('yoast_breadcrumb')) echo yoast_breadcrumb(); @endphp
			</div>
		</div>
	</div>
</div>
