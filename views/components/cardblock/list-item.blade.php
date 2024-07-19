@php
    $pageTitle = $page['title'] ?? '';
    $pageExcerpt = get_the_excerpt($page['id']);
    $pageUrl = $page['url'] ?? '';
    $pageIcon = json_decode($page['icon'], true);
    $imageID = $page['image_id'] ?? 0;
    $featuredImageId = $page['featured_image_id'] ?? '';

    $postType = get_post_type($pageId);
    $pageId = $page['id'];
    $terms = [];
    if ($postType === 'page') {
        // Fetch categories for pages
        $terms = get_the_category($pageId);
    } else {
        // Fetch terms from the custom taxonomy 'branches_categories'
        $terms = get_the_terms($pageId, $postType . '_categories');
    }

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

{{--Variant 1 is content in kaart--}}
@if ($cardVariant == 'variant1')
    @include('components/cardblock/variant-1')
{{--Variant 2 is content onder kaart--}}
@elseif ($cardVariant == 'variant2')
    @include('components/cardblock/variant-2')
@endif