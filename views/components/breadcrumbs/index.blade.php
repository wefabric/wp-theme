<div class="w-full py-10 bg-{{ $breadcrumbsBackgroundColor }} text-{{ $breadcrumbsTextColor }}">
	<div class="relative z-10 px-8 container mx-auto">
		<div class="flex text-base ">
			<div class="flex items-center">
				<a href="/"><i class="fas fa-home mr-1 hover:text-secondary"></i></a>
				@php if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs(); @endphp
				@php if (function_exists('yoast_breadcrumb')) echo yoast_breadcrumb(); @endphp
			</div>
		</div>
	</div>
</div>