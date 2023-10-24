@php
//    $currentCategory = null;
//    if($currentCatId = get_query_var( 'cat' )) {
//        $currentCategory = get_category($currentCatId);
//    }
@endphp

<div class="">
    <div class="block flex flex-wrap gap-2">
        @foreach(get_categories() as $category)
            <a href="{{ get_category_link($category) }}" class="bg-primary hover:bg-primary-dark text-white px-4 py-2 rounded-full">{{ $category->name }}</a>
        @endforeach
    </div>
</div>