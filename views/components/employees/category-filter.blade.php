@php
    // Get current category IDs from URL query
    $currentCatIds = isset($_GET['employee_category']) ? array_map('intval', explode(',', $_GET['employee_category'])) : [];
    $currentTerms = [];
    foreach ($currentCatIds as $catId) {
        $currentTerms[] = get_term($catId, 'employee_categories');
    }

    $categories = get_terms([
        'taxonomy' => 'employee_categories',
        'hide_empty' => true,
    ]);

    $multipleFilters = $block['data']['multiple_filters_enabled'] ?? false;
@endphp

<div class="category-list block flex flex-wrap gap-2">
    @if($categories && !is_wp_error($categories))
        @php
            // URL without any category filters
            $allCategoriesUrl = remove_query_arg('employee_category');
        @endphp

        {{-- Filter for all --}}
        <a href="{{ $allCategoriesUrl }}"
           class="category category-link px-4 py-2 rounded-full border-2 border-primary hover:bg-primary hover:text-white {{ empty($currentCatIds) ? 'bg-primary text-white' : '' }}">
            Alles
        </a>

        @foreach($categories as $category)
            @php
                $categoryColor = get_field('category_color', 'employee_categories_' . $category->term_id);
                $isActive = in_array($category->term_id, $currentCatIds);

                if ($multipleFilters) {
                    $newCatIds = $isActive ? array_diff($currentCatIds, [$category->term_id]) : array_merge($currentCatIds, [$category->term_id]);
                } else {
                    $newCatIds = $isActive ? [] : [$category->term_id];
                }

                $url = empty($newCatIds) ? remove_query_arg('employee_category') : add_query_arg('employee_category', implode(',', $newCatIds), get_permalink());
                $style = '';
                $class = 'category hover:text-white border-2 category-link px-4 py-2 rounded-full';

                if ($isActive && $categoryColor) {
                    // Active category with color
                    $style = "border: 2px solid $categoryColor; background-color: $categoryColor; color: white;";
                    $class .= " bg-primary text-white";
                } elseif ($isActive && !$categoryColor) {
                    // Active category without color
                    $class .= " border-primary bg-primary text-white";
                } elseif (!$isActive && $categoryColor) {
                    // Inactive category with color
                    $style = "border: 2px solid $categoryColor; color: $categoryColor;";
                    $class .= " border-primary hover:bg-primary hover:text-white";
                } else {
                    // Inactive category without color
                    $class .= " border-primary hover:bg-primary hover:text-white";
                }
            @endphp
            <a href="{{ $url }}"
               style="{{ $style }}"
               class="{{ $class }}"
               @if(!$isActive && $categoryColor)
                    onmouseover="this.style.backgroundColor='{{ $categoryColor }}'; this.style.color='white';"
                    onmouseout="this.style.backgroundColor=''; this.style.color='{{ $categoryColor }}';"
               @endif>
               {!! $category->name !!}
            </a>
        @endforeach
    @endif
</div>
