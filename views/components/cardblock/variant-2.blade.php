<div id="{{ str_replace(' ', '-', strtolower($pageTitle)) }}" class="content-under-card-item card-item group h-full @if ($flyinEffect) card-hidden @endif">
    <div class="custom-radius bg-{{ $cardBackgroundColor }} rounded-{{ $borderRadius }} h-full flex flex-col {{ $hoverEffectClass }} duration-300 ease-in-out overflow-hidden">
        <div>
            <div class="image-container h-[360px] relative overflow-hidden rounded-t-{{ $borderRadius }}">

                @if (!empty($visibleElements) && in_array('category', $visibleElements))
                    @if (!empty($terms) && is_array($terms) && !is_bool($terms))
                        <div class="card-categories absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                            @foreach ($terms as $term)
                                @php
                                    $categoryColor = get_field('category_color', $term);
                                    $categoryIcon = get_field('category_icon', $term);
                                @endphp
                                <div style="background-color: {{ $categoryColor }}" class="card-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full flex items-center gap-x-1">
                                    {!! $categoryIcon !!} {!! $term->name !!}
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endif

                @if ($cardVisual == 'featured_image' && $featuredImageId)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="card-overlay absolute left-0 top-0 w-full h-full @if ($cardOverlayColor) opacity-50 group-hover:opacity-50 bg-{{ $cardOverlayColor }} @else opacity-0 group-hover:opacity-50 bg-primary @endif z-10 transition-opacity duration-300 ease-in-out"></a>

                    @include('components.image', [
                     'image_id' => $featuredImageId,
                     'size' => 'full',
                     'object_fit' => 'cover',
                     'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                     'alt' => $pageTitle
                  ])
                @elseif ($cardVisual == 'icon' && $pageIcon)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="absolute left-0 top-0 w-full h-full"></a>
                    <div class="h-full flex justify-center items-center">
                        <a class="page-icon" href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina">
                            <i class="text-{{ $cardIconColor }} relative z-20 text-[200px] fa-{{ $pageIcon['style'] }} fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-primary transition-all duration-300 ease-in-out"></i>
                        </a>
                    </div>
                @elseif ($cardVisual == 'image' && $imageId)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="card-overlay absolute left-0 w-full h-full @if ($cardOverlayColor) opacity-50 group-hover:opacity-50 bg-{{ $cardOverlayColor }} @else opacity-0 group-hover:opacity-50 bg-primary @endif z-10 transition-opacity duration-300 ease-in-out"></a>
                    @include('components.image', [
                       'image_id' => $imageId,
                       'size' => 'full',
                       'object_fit' => 'cover',
                       'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                       'alt' => $pageTitle
                    ])
                @endif
            </div>
        </div>
        @if (!empty($visibleElements) && is_array($visibleElements) &&
            (in_array('title_text', $visibleElements) ||
             in_array('overview_text', $visibleElements) ||
             in_array('button', $visibleElements)))
            <div class="content-box h-full flex flex-col gap-y-4 p-6 xl:p-8">
                @if (in_array('title_text', $visibleElements) && $pageTitle)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="card-title h3 text-{{ $cardTitleColor }} relative z-20 font-bold group-hover:text-primary transition-all duration-300 ease-in-out">
                        {!! !empty($customPageTitle) ? $customPageTitle : $pageTitle !!}
                    </a>
                @endif
                @if (in_array('overview_text', $visibleElements) && $pageExcerpt)
                    <p class="card-excerpt text-{{ $cardTextColor }}">{{ $pageExcerpt }}</p>
                @endif
                @if (in_array('button', $visibleElements))
                    @if ($buttonCardText)
                        <div class="button-container mt-auto z-10">
                            @include('components.buttons.default', [
                                'text' => $buttonCardText,
                                'href' => $pageUrl,
                                'alt' => $buttonCardText,
                                'colors' => 'btn-' . $buttonCardColor . ' btn-' . $buttonCardStyle,
                                'class' => 'rounded-lg',
                                'icon' => $buttonCardIcon,
                            ])
                        </div>
                    @endif
                @endif
            </div>
        @endif
</div>
</div>