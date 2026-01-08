@php
	$parentCategories = get_categories([
		'taxonomy' => 'product_cat',
		'hide_empty' => false,
        'order_by' => 'menu_order',
		'parent' => 0
	]);

	$categories = [];


	foreach($parentCategories as $parentCategory) {

         $active = false;
		 if(get_queried_object() instanceof WP_Term && get_queried_object()->slug === $parentCategory->slug) {
			 $active = true;
		 }

         $categories[$parentCategory->term_id] = $parentCategory;
         $categories[$parentCategory->term_id]->active  = $active;
		 $categories[$parentCategory->term_id]->subcategories = [];
		 $categories[$parentCategory->term_id]->subcategory_count = 0;

         if($childCategories = get_categories(['taxonomy' => 'product_cat', 'parent' => $parentCategory->term_id])) {
             $categories[$parentCategory->term_id]->subcategory_count = $childCategories;

             foreach ($childCategories as $childCategory) {
                  	$childActive = false;
					$activeClass = 'hover:text-primary ';
					if(get_queried_object() instanceof WP_Term && get_queried_object()->slug === $childCategory->slug) {
						 $active = true;
						 $activeClass .= 'text-primary';
					}

                    if($active) {
                        $categories[$parentCategory->term_id]->active = true;
					}

                    $childCategory->active = $active;
                    $childCategory->activeClass = $activeClass;
                    $categories[$parentCategory->term_id]->subcategories[] = $childCategory;
             }
         }
	}

@endphp
<div  class="sidebar-widget sidebar-widget--category-tree">

	<div class="title-text">Categorie</div>

	@foreach($categories as $category)


		<div class="product-category break-words px-3 @if($category->subcategory_count == 0) no-subcategories @endif @if($category->active) bg-black active @else bg-[#F5F3F3] @endif">

			@php

			$linkClass =  'inline-block w-[90%]';
			if(!$category->active):
                $linkClass .= ' text-black';
			endif;

			@endphp
			 @include('components.link.simple', [
				'href' => get_category_link($category->term_taxonomy_id),
				'text' => html_entity_decode($category->name),
				'class' => $linkClass
			])


			<input class="product-category__trigger" @if($category->active) checked="checked" @endif id="product-category-{{ $category->slug }}" type="checkbox" />
			<label class="product-category__title " for="product-category-{{ $category->slug }}">{{ '' ?? $category->name }}</label>

			@if($category->subcategory_count > 0)
				<div class="product-subcategories">
					@foreach($category->subcategories as $subcategory)
						<div class="product-subcategory">

							@include('components.link.simple', [
								'href' => get_category_link($subcategory->term_taxonomy_id),
								'text' => html_entity_decode($subcategory->name),
								'class' => 'inline-block '. $subcategory->activeClass
							])


							@if($subcategory->subcategory_count > 0)
								<div class="product-subcategories">
									@foreach($subcategory->subcategories as $subSubcategory)
										<div class="product-subcategory">

											@include('components.link.simple', [
                                                'href' => get_category_link($subSubcategory->term_taxonomy_id),
                                                'text' => '-'. html_entity_decode($subcategory->name),
                                                'class' => 'inline-block '. $subSubcategory->activeClass
                                            ])

										</div>
									@endforeach
								</div>
							@endif

						</div>
					@endforeach
				</div>
			@endif

		</div>
	@endforeach

</div>