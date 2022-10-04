@php
	$currentCategory = null;
	if($currentCatId = get_query_var( 'cat' )) {
		$currentCategory = get_category($currentCatId);
	}
@endphp
<div class="mt-12 mb-24">
	<span class="h5 block mb-3">{{ 'Waar ben je naar op zoek?' }}</span>
	<div class="block md:flex md:flex-row">
		<a href="{{ get_permalink(get_option('page_for_posts')) }}" class="mr-3 h-full w-fit md:w-auto block h-[37px]">
             <span class="flex rounded-md text-white px-4 py-2 uppercase bg-primary h-full block">
                <span class="self-center leading-none font-bold">Alles</span>
            </span>
		</a>
		
		@foreach(get_categories() as $category)
			<a href="{{ get_category_link($category) }}" class="block w-fit @if(!$loop->last) mr-3 @endif">
				@include('components.news.category-icon', ['category' => $category, 'active_states' => true, 'active' => $currentCategory && $currentCategory->cat_ID === $category->cat_ID])
			</a>
		@endforeach
	</div>
</div>