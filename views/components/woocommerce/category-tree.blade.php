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

			$active = false;
			if(get_queried_object() instanceof WP_Term && get_queried_object()->slug === $cat->slug) {
				 $active = true;
			}
			$categories[$cat->term_id]->active = $active;


		} elseif(array_key_exists($cat->parent, $categories)) {
            $active = false;
			$activeClass = '';
			if(get_queried_object() instanceof WP_Term && get_queried_object()->slug === $cat->slug) {
				 $active = true;
				 $activeClass = 'text-primary';
			}
            $cat->active = $active;
            $cat->activeClass = $activeClass;
			$categories[$cat->parent]->subcategories[] = $cat;
            if($active) {
                   $categories[$cat->parent]->active = true;
            }

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
		<div class="product-category @if($category->subcategory_count == 0) no-subcategories @endif @if($category->active) bg-primary @else bg-black @endif">

			 @include('components.link.simple', [
				'href' => get_category_link($category->term_taxonomy_id),
				'text' => $category->name,
				'class' => 'inline-block w-[90%]'
			])
			
			<input class="product-category__trigger" @if($category->active) checked="checked" @endif id="product-category-{{ $category->slug }}" type="checkbox" />
			<label class="product-category__title " for="product-category-{{ $category->slug }}">{{ '' ?? $category->name }}</label>
			
			@if($category->subcategory_count > 0)
				<div class="product-subcategories">
					@foreach($category->subcategories as $subcategory)
						<div class="product-subcategory">
							
							@include('components.link.simple', [
								'href' => get_category_link($subcategory->term_taxonomy_id),
								'text' => $subcategory->name,
								'class' => 'inline-block '. $subcategory->activeClass
							])
							
						</div>
					@endforeach
				</div>
			@endif
			
		</div>
	@endforeach
	
</div>
