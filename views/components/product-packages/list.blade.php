@php
    $visibleElements = $block['data']['show_element'] ?? [];

    $allCategories = get_terms([
        'taxonomy' => 'productpackage_categories',
        'hide_empty' => false,
    ]);

    $productPackagesCategories = [];
    foreach ($productPackages as $productPackageId) {
        $productPackagesCategories[$productPackageId] = wp_get_post_terms($productPackageId, 'productpackage_categories', ['fields' => 'ids']);
    }
@endphp


<!-- Desktop layout -->
<div class="hidden md:block overflow-x-auto">
    <table class="product-specification-table border-collapse w-full lg:table-fixed">
        <thead>
            <tr>
                <th class="px-2 lg:px-6 py-2 lg:py-4 text-center"></th>

                @foreach ($productPackages as $productPackageId)
                    @php
                        $post = get_post($productPackageId);
                        $fields = get_fields($productPackageId);

                        $productText = $fields['product_text'] ?? '';
                        $productPrice = $fields['product_price'] ?? '';
                        $productButton = $fields['product_button'] ?? '';

                        // Product pakket button
                        $productButtonText = $fields['product_button']['title'] ?? '';
                        $productButtonLink = $fields['product_button']['url'] ?? '';
                        $productButtonTarget = $fields['product_button']['target'] ?? '_self';
                        $productButtonColor = $block['data']['card_button_button_color'] ?? '';
                        $productButtonStyle = $block['data']['card_button_button_style'] ?? '';
                    @endphp

                    <th class="border border-gray-300 px-2 lg:px-6 py-2 lg:py-4 text-center align-top">
                        <div class="font-bold text-lg mb-2 text-{{ $productTitleColor }}">{!! $post->post_title !!}</div>

                        @if ($productText && !empty($visibleElements) && in_array('overview_text', $visibleElements))
                            <div class="text-sm mb-2 text-{{ $productTextColor }}">{!! $productText !!}</div>
                        @endif

                        @if ($productPrice && !empty($visibleElements) && in_array('price', $visibleElements))
                            <div class="text-lg font-semibold mb-2">{!! $productPrice !!}</div>
                        @endif

                        @if ($productButton && !empty($visibleElements) && in_array('button', $visibleElements))
                            <div class="card-button mt-4">
                                @include('components.buttons.default', [
                                    'text' => $productButtonText,
                                    'href' =>  $productButtonLink,
                                    'alt' =>  $productButtonText,
                                    'colors' => 'btn-' . $productButtonColor . ' btn-' . $productButtonStyle,
                                    'class' => 'rounded-lg',
                                    'target' => $productButtonTarget,
                                ])
                            </div>
                        @endif

                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>

        @foreach ($allCategories as $category)
            <tr>
                <td class="bg-gray-100 border border-gray-300 px-2 lg:px-6 py-2 lg:py-4 font-bold">{{ $category->name }}</td>
                @foreach ($productPackages as $productPackageId)
                    <td class="border border-gray-300 px-2 lg:px-6 py-2 lg:py-4 text-center">
                        @if (in_array($category->term_id, $productPackagesCategories[$productPackageId]))
                            ✔️
                        @else
                            -
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach

        </tbody>
    </table>
</div>


<!-- Mobile layout -->
<div class="block md:hidden overflow-x-auto">
    <div class="min-w-max">
        <div class="grid grid-cols-{{ count($productPackages) }}">
            @foreach ($productPackages as $index => $productPackageId)
                @php
                    $post = get_post($productPackageId);
                    $fields = get_fields($productPackageId);

                    $productText = $fields['product_text'] ?? '';
                    $productPrice = $fields['product_price'] ?? '';
                    $productButton = $fields['product_button'] ?? '';

                    // Product pakket button
                    $productButtonText = $fields['product_button']['title'] ?? '';
                    $productButtonLink = $fields['product_button']['url'] ?? '';
                    $productButtonTarget = $fields['product_button']['target'] ?? '_self';
                    $productButtonColor = $block['data']['card_button_button_color'] ?? '';
                    $productButtonStyle = $block['data']['card_button_button_style'] ?? '';
                @endphp

                <div class="text-center px-4 py-4 border border-gray-300">
                    <div class="font-bold text-md mb-2 text-{{ $productTitleColor }}">
                        {!! $post->post_title !!}
                    </div>

                    @if ($productText && !empty($visibleElements) && in_array('overview_text', $visibleElements))
                        <div class="text-sm mb-2 text-{{ $productTextColor }} max-w-[200px]">{!! $productText !!}</div>
                    @endif

                    @if ($productPrice && !empty($visibleElements) && in_array('price', $visibleElements))
                        <div class="text-md font-semibold mb-2">{!! $productPrice !!}</div>
                    @endif

                    @if ($productButton && !empty($visibleElements) && in_array('button', $visibleElements))
                        <div class="card-button mt-2">
                            @include('components.buttons.default', [
                                'text' => $productButtonText,
                                'href' =>  $productButtonLink,
                                'alt' =>  $productButtonText,
                                'colors' => 'btn-' . $productButtonColor . ' btn-' . $productButtonStyle,
                                'class' => 'rounded-lg px-2 py-1',
                                'target' => $productButtonTarget,
                            ])
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        @foreach ($allCategories as $category)
            <div class="mt-4">
                <div class="bg-gray-100 p-3 text-sm font-bold">{{ $category->name }}</div>
                <div class="grid grid-cols-{{ count($productPackages) }} border-t border-gray-300">
                    @foreach ($productPackages as $index => $productPackageId)
                        @php
                            $isChecked = in_array($category->term_id, $productPackagesCategories[$productPackageId]);
                        @endphp

                        <div class="p-3 text-center border border-gray-300">
                            @if ($isChecked)
                                ✔️
                            @else
                                -
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>