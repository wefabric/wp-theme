<div id="{!! trim(preg_replace('/[^a-z0-9]+/', '-', strtolower(html_entity_decode($pageTitle))), '-') !!}" class="content-in-card-item card-item group h-full w-full @if ($flyinEffect) card-hidden @endif">
    <div class="card-background p-6 xl:p-8 h-full mx-auto relative bg-{{ $cardBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-center text-center overflow-hidden rounded-{{ $borderRadius }} {{ $hoverEffectClass }} duration-300 ease-in-out"
        @if ($cardVisual == 'featured_image' && $featuredImageId && ($imageView == 'background_image'))
             style="background-image: url('{{ wp_get_attachment_image_url($featuredImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($featuredImageId) }}">
        @elseif ($cardVisual == 'image' && $imageId && ($imageView == 'background_image'))
             style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
        @else >
        @endif

        <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
           class="card-overlay left-0 top-0 absolute h-full w-full @if ($cardOverlayColor) opacity-50 group-hover:opacity-50 bg-{{ $cardOverlayColor }} @else opacity-0 group-hover:opacity-50 bg-primary @endif z-10 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>

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

        <div class="content-wrapper w-full flex flex-col items-center gap-y-4">
            @if ($pageIcon)
                <a class="page-icon" href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina">
                    <i class="text-{{ $cardIconColor }} page-icon relative z-20 text-[32px] md:text-[40px] fa-{{ $pageIcon['style'] }} fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-white transition-all duration-300 ease-in-out"></i>
                </a>
            @endif

            @if (($cardVisual == 'image' && $imageId) && ($imageView == 'normal_image') || ($cardVisual == 'featured_image' && $featuredImageId) && ($imageView == 'normal_image'))
                @include('components.image', [
                    'image_id' => $cardVisual == 'featured_image' ? $featuredImageId : $imageId,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'w-full object-cover rounded-' . $borderRadius,
                    'alt' => $pageTitle,
                ])
            @endif


            @if (is_array($visibleElements) && !empty($visibleElements) && in_array('title_text', $visibleElements) && $pageTitle)
                <a href="{{ $pageUrl }} " aria-label="Ga naar {{ $pageTitle }} pagina"
                   class="page-title h4 text-{{ $cardTitleColor }} relative z-20 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
                    {!! !empty($customPageTitle) ? $customPageTitle : $pageTitle !!}
                </a>
            @endif
            @if (is_array($visibleElements) && !empty($visibleElements) && in_array('overview_text', $visibleElements) && $pageExcerpt)
                <p class="text-{{ $cardTextColor }} page-excerpt relative z-20 group-hover:text-white transition-all duration-300 ease-in-out">{!! $pageExcerpt !!}</p>
            @endif
            @if (is_array($visibleElements) && !empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="page-button relative z-20 flex items-center">
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
    </div>
</div>