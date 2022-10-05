@php
	$currentCategory = null;
	if($currentCatId = get_query_var( 'cat' )) {
		$currentCategory = get_category($currentCatId);
	}
@endphp
<div class="{{ $class ?? '' }}">
	<div class="block md:flex md:flex-row">
		@include('components.buttons.default', [
			'href' => get_permalink(get_option('page_for_posts')),
			'text' => 'Alles weergeven',
			'alt' => __('Filter alle categoriën'),
			'colors' => empty($currentCategory) ? 'btn-primary-dark' : 'btn-gray',
			'a_class' => 'mr-3',
		])
		
		@foreach(get_categories() as $category)
			{{-- include('components.news.category-icon', [ ... ]) --}}
			@include('components.buttons.default', [
				'href' => get_category_link($category),
				'text' => $category->name,
				'colors' => 'btn-'. (!empty($currentCategory) && $currentCategory->cat_ID === $category->cat_ID ? 'primary-dark' : 'gray'),
				'a_class' => ' '. (!$loop->last ? 'mr-3' : ''),
			])
		@endforeach
	</div>
</div>