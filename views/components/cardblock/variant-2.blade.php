<div id="{{ str_replace(' ', '-', strtolower($pageTitle)) }}" class="content-under-card-item card-item group h-full">
    <div class="bg-{{ $cardBackgroundColor }} rounded-{{ $borderRadius }} h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out overflow-hidden">
        <div>
            <div class="image-container h-[360px] relative overflow-hidden rounded-t-{{ $borderRadius }}">
                @if ($block['data']['block_visual'] == 'featured_image' && $featuredImageId)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="absolute left-0 top-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                    @if (!empty($visibleElements) && in_array('category', $visibleElements))
                        @if ($terms && !is_bool($terms))
                            <div class="absolute z-20 top-[15px] left-[15px] flex flex-wrap gap-2">
                                @foreach ($terms as $term)
                                    @php
                                        $categoryColor = get_field('category_color', $term);
                                    @endphp
                                    <div style="background-color: {{ $categoryColor }}" class="card-category @if(empty($categoryColor)) bg-primary @endif text-white px-4 py-2 rounded-full">
                                        {!! $term->name !!}
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    @include('components.image', [
                     'image_id' => $featuredImageId,
                     'size' => 'job-thumbnail',
                     'object_fit' => 'cover',
                     'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                     'alt' => $pageTitle
                  ])
                @elseif ($block['data']['block_visual'] == 'icon' && $pageIcon)
                    <div class="h-full flex justify-center items-center">
                        <i class="text-{{ $cardTitleColor }} relative z-20 text-[200px] fa-{{ $pageIcon['style'] }} fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-primary transition-all duration-300 ease-in-out"></i>
                    </div>
                @elseif ($block['data']['block_visual'] == 'image' && $imageID)
                    <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
                       class="absolute left-0 w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                    @include('components.image', [
                       'image_id' => $imageID,
                       'size' => 'job-thumbnail',
                       'object_fit' => 'cover',
                       'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                       'alt' => $pageTitle
                    ])
                @endif
            </div>
        </div>
        <div class="content-box h-full flex flex-col gap-y-4 p-6 xl:p-8">
            <a href="{{ $pageUrl }}" aria-label="Ga naar {{ $pageTitle }} pagina"
               class="card-title text-{{ $cardTitleColor }} relative z-20 h3 font-bold group-hover:text-primary transition-all duration-300 ease-in-out">
                {!! $pageTitle !!}
            </a>
            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && $pageExcerpt)
                <p class="card-excerpt text-{{ $cardTextColor }}">{{ $pageExcerpt }}</p>
            @endif
            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                @if ($buttonCardText)
                    <div class="button-container mt-auto z-10">
                        @include('components.buttons.default', [
                           'text' => $buttonCardText,
                           'href' => $pageUrl,
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