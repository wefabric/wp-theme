@php
    $fields = get_fields($product);
    $productThumbnailID = get_post_thumbnail_id($product);
    $productTitle = get_the_title($product);

    $productImage = $fields['product_image'] ?? '';
    $productUrl = $fields['external_url'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
        $productSummary = get_the_excerpt($product);
        $maxSummaryLength = 180;
        if (strlen($productSummary) > $maxSummaryLength) {
            $productSummary = substr($productSummary, 0, $maxSummaryLength - 3) . '...';
        }

    $serviceCategories = get_the_terms($product, 'division_categories');
@endphp

<div class="product-item group h-full">
    <div class="product-wrapper relative h-full flex flex-col @if($productUrl)group-hover:-translate-y-4 duration-300 ease-in-out @endif">
        @if ($productImage)
            <div class="product-image max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                @if($productUrl)
                    <a href="{{ $productUrl }}" target="_blank" aria-label="Ga naar {{ $productTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @endif
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($productCategories && !is_bool($productCategories))
                        <div class="product-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($productCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                    $categoryIcon = get_field('category_icon', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="product-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                                    {!! $categoryIcon !!} {!! $category->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif
                @include('components.image', [
                   'image_id' => $productImage,
                   'size' => 'job-thumbnail',
                   'object_fit' => 'cover',
                   'img_class' => 'aspect-square w-full h-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110',
                   'alt' => $productTitle,
           ])
            </div>
        @endif
        <div class="product-data flex flex-col w-full grow mt-5">

            @if($productUrl)
                <a href="{{ $productUrl }}" aria-label="Ga naar {{ $productTitle }} pagina"
                   class="product-title text-{{ $productTitleColor }} font-bold text-lg group-hover:text-primary">{!! $productTitle !!}</a>
            @else
                <div class="product-title text-{{ $productTitleColor }} font-bold text-lg">{!! $productTitle !!}</div>
            @endif

            <div class="product-info mt-4 text-{{ $productTextColor }}">
                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($productSummary))
                    <p class="product-summary mt-3 mb-3">{{ $productSummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $productUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg text-left',
                       ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>