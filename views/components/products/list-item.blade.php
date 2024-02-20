@php
    $fields = get_fields($product);
    $productThumbnailID = get_post_thumbnail_id($product);
    $productTitle = get_the_title($product);

    $productImage = $fields['product_image'] ?? '';
    $productUrl = $fields['external_url'] ?? '';

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
    $productSummary = $fields['excerpt'] ?? '';
    $productCategories = get_the_terms($product, 'division_categories');
@endphp

<div class="product-item group h-full">
    <div class="h-full flex flex-col items-center group-hover:-translate-y-4 duration-300 ease-in-out">
        @if ($productImage)
            <div class="max-h-[360px] overflow-hidden w-full relative rounded-{{ $borderRadius }}">
                <a href="{{ $productUrl }}" target="_blank" aria-label="Ga naar {{ $productTitle }} pagina"
                   class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if ($productCategories && !is_bool($productCategories))
                        <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($productCategories as $category)
                                @php
                                    $categoryColor = get_field('category_color', $category);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="@if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                                    {{ $category->name }}
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
        <div class="flex flex-col w-full grow mt-5">

            <a href="{{ $productUrl }}" aria-label="Ga naar {{ $productTitle }} pagina" class="font-bold text-{{ $productTitleColor }} text-lg group-hover:text-primary">{{ $productTitle }}</a>

            <div class="vacancy-data mt-4 text-{{ $vacancyTextColor }}">

                @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && !empty($vacancySummary))
                    <p class="mt-3 mb-3">{{ $vacancySummary }}</p>
                @endif
            </div>

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="mt-auto pt-8 z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $vacancyUrl,
                           'alt' => $buttonCardText,
                           'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                           'class' => 'rounded-lg',
                       ])
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>