<div class="breadcrumbs breadcrumbs-{{ $breadcrumbsLocation }} {{ $headerName }} w-full py-4 lg:py-8 bg-{{ $breadcrumbsBackgroundColor ?? 'bg-transparent' }} text-{{ $breadcrumbsTextColor ?? 'text-black' }}">
    <div class="relative z-10 @if ($breadcrumbsLocation !== 'inside' ) px-8 container mx-auto @endif">
        <div class="breadcrumbs-wrapper">
            @php
                add_filter('rank_math/frontend/breadcrumb/html', function($html, $crumbs, $class) {
                    // Replace the first 'Home' text with the icon
                    if (!empty($crumbs) && isset($crumbs[0][0]) && strip_tags($crumbs[0][0]) === 'Home') {
                         // We want to replace the text within the first breadcrumb link or span
                         $icon = '<i class="fa-regular fa-house"></i>';
                         // Very basic replacement for the first occurrence of 'Home' in the HTML
                         // RankMath usually outputs something like <a href="...">Home</a> or <span ...>Home</span>
                         $html = preg_replace('/(>)(Home)(<\/)/', '$1' . $icon . '$3', $html, 1);
                    }
                    return $html;
                }, 10, 3);

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
                        
                        $crumb_name = is_array($crumb) ? ($crumb[0] ?? '') : $crumb;
                        $crumb_url = is_array($crumb) ? ($crumb[1] ?? '') : '';

                        // Voorkom dubbele 'Home' als RankMath die al toevoegt
                        if (in_array(strtolower(strip_tags($crumb_name)), ['home', ''])) {
                            continue;
                        }

                        $item = [
                            '@type' => 'ListItem',
                            'position' => $i,
                            'name' => strip_tags($crumb_name),
                        ];

                        if (!empty($crumb_url)) {
                            $item['item'] = $crumb_url;
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