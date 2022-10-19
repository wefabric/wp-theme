@php
	$cats = get_terms([
		'taxonomy' => 'product_cat', // meow
		'hide_empty' => false,
		'orderby' => 'term_id',
	]);
//	dd($cats);

	$categories = [];
	foreach($cats as $cat) {
		if($cat->slug == 'uncategorized') {
			continue;
		} //hide uncategorized
		
		if($cat->parent == 0) {
			$categories[$cat->term_id] = $cat;
			$categories[$cat->term_id]->subcategories = [];
		} elseif(array_key_exists($cat->parent, $categories)) {
			$categories[$cat->parent]->subcategories[] = $cat;
//		} else {
			//third-level category: todo search in $cats for each subcat if is parent.
		}
	}
	foreach($categories as $category) {
		$category->subcategory_count = count($category->subcategories);
	}
@endphp

<div class="sidebar-widget sidebar-widget--category-tree">
	@foreach($categories as $category)
		<div class="product-category @if($category->subcategory_count == 0) no-subcategories @endif">
			
			 @include('components.link.simple', [
				'href' => get_category_link($category->term_taxonomy_id),
				'text' => $category->name,
			])
			
			<input class="product-category__trigger" id="product-category-{{ $category->slug }}" type="checkbox" />
			<label class="product-category__title " for="product-category-{{ $category->slug }}">{{ '' ?? $category->name }}</label>
			
			@if($category->subcategory_count > 0)
				<div class="product-subcategories">
					@foreach($category->subcategories as $subcategory)
						<div class="product-subcategory">
							
							@include('components.link.simple', [
								'href' => get_category_link($subcategory->term_taxonomy_id),
								'text' => $subcategory->name,
							])
							
						</div>
					@endforeach
				</div>
			@endif
			
		</div>
	@endforeach
	
</div>
