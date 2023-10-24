@php
    $pageTitle = $page['title'] ?? '';
    $pageUrl = $page['url'] ?? '';
    $pageIcon = json_decode($page['icon'], true);
    $imageID = $page['image_id'] ?? 0;

    $featuredImageId = $page['featured_image_id'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $pageExcerpt = get_the_excerpt($page['id']);
@endphp

@if ($cardVariant == 'variant1')
    @include('components/cardblock/variant-1')
@elseif ($cardVariant == 'variant2')
    @include('components/cardblock/variant-2')
@endif