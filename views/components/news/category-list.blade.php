@php
    $currentCatId = get_query_var('cat');
    $currentTerm = ($currentCatId) ? get_category($currentCatId) : null;
    $newsArchiveLink = esc_url(get_post_type_archive_link('post'));
@endphp

<div class="category-list block flex flex-wrap gap-2">
    {{-- Create the 'alles' filter button --}}
    <a href="{{ $newsArchiveLink }}"
       class="border-primary hover:bg-primary hover:text-white border-2 category-link px-4 py-2 rounded-full @if(!$currentCatId) bg-primary text-white @endif">
        Alles
    </a>

    @php
        $categories = get_categories(array(
            'hide_empty' => false,
        ));
    @endphp

    @if($categories)
        @foreach($categories as $category)
            @php
                // Ensure the category has posts
                $categoryPosts = get_posts(array(
                    'category' => $category->term_id,
                    'numberposts' => 1, // We only need to check if there's at least one post
                ));

                if (empty($categoryPosts)) {
                    continue; // Skip this category if it has no posts
                }

                $categoryColor = get_field('category_color', 'category_' . $category->term_id);
                $isActive = ($currentTerm && $currentTerm->term_id == $category->term_id);
                $categoryLink = $isActive ? $newsArchiveLink : get_category_link($category);
            @endphp
            <a href="{{ $categoryLink }}"
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
