@php
//    $currentCategory = null;
//    if($currentCatId = get_query_var( 'cat' )) {
//        $currentCategory = get_category($currentCatId);
//    }
@endphp

<div class="">
    <div class="block flex flex-wrap gap-2">
        @foreach(get_categories() as $category)
            @php
                $categoryColor = get_field('category_color', 'category_' . $category->term_id);
            @endphp
            <a href="{{ get_category_link($category) }}" style="background-color: {{ $categoryColor }}" class="@if(empty($categoryColor)) bg-primary hover:bg-primary-dark @endif text-white px-4 py-2 rounded-full">{!! $category->name !!}</a>
        @endforeach
    </div>
</div>