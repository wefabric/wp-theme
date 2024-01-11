@php
    $currentCatId = get_query_var('cat');
    $currentTerm = ($currentCatId) ? get_category($currentCatId) : null;
@endphp

<div class="category-list block flex flex-wrap gap-2">
    @php
        $categories = get_categories(array(
            'hide_empty' => false,
        ));
    @endphp

    @if($categories)
        @foreach($categories as $category)
            @php
                $categoryColor = get_field('category_color', 'category_' . $category->term_id);
                $isActive = ($currentTerm && $currentTerm->term_id == $category->term_id);
            @endphp
            <a href="{{ get_category_link($category) }}"
               style="@if($categoryColor && !$isActive) border: 2px solid {{ $categoryColor }}; color: {{ $categoryColor }}; @elseif($categoryColor && $isActive)  border: 2px solid {{ $categoryColor }}; background-color: {{ $categoryColor }}; color: white;@endif"
               class="@if(empty($categoryColor) && !$isActive) border-primary hover:bg-primary hover:text-white @elseif(empty($categoryColor) && $isActive) border-primary bg-primary text-white @endif hover:text-white border-2 category-link px-4 py-2 rounded-full"
               @if(!$isActive)
                   onmouseover="this.style.backgroundColor='{{ $categoryColor }}'; this.style.color='white'"
                   onmouseout="this.style.backgroundColor='transparent'; this.style.color='{{ $categoryColor }}'"
               @endif>
               {!! $category->name !!}
            </a>
        @endforeach
    @endif
</div>
