<div class="breadcrumbs breadcrumbs-{{ $breadcrumbsLocation }} {{ $headerName }} w-full py-4 lg:py-8 bg-{{ $breadcrumbsBackgroundColor ?? 'bg-transparent' }} text-{{ $breadcrumbsTextColor ?? 'text-black' }}">
    <div class="relative z-10 @if ($breadcrumbsLocation !== 'inside' ) px-8 container mx-auto @endif">
        <div class="breadcrumbs-wrapper">
            @php
                if (function_exists('rank_math_the_breadcrumbs')) rank_math_the_breadcrumbs();
                if (function_exists('yoast_breadcrumb')) echo yoast_breadcrumb();

                $crumbs = [];
                if (class_exists('\RankMath\Frontend\Breadcrumbs')) {
                    $crumbs = \RankMath\Frontend\Breadcrumbs::get()->get_crumbs();
                }

                if (!empty($crumbs)) {
                    $itemListElement = [];
                    $i = 1;
                    foreach ($crumbs as $crumb) {
                        if (!empty($crumb['hide_in_schema'])) {
                            continue;
                        }

                        // Consistent met de filter in functions.php (Home/home/HOME verwijderen)
                        if (in_array(strtolower($crumb[0]), ['home'])) {
                            continue;
                        }

                        $item = [
                            '@type' => 'ListItem',
                            'position' => $i,
                            'name' => strip_tags($crumb[0]),
                        ];

                        if (!empty($crumb[1])) {
                            $item['item'] = $crumb[1];
                        }

                        $itemListElement[] = $item;
                        $i++;
                    }

                    if (!empty($itemListElement)) {
                        \Wefabric\WPSupport\Schema\JsonLd::addSchema('breadcrumb_list', [
                            '@type' => 'BreadcrumbList',
                            'itemListElement' => $itemListElement,
                        ]);
                    }
                }
            @endphp
        </div>
    </div>
</div>