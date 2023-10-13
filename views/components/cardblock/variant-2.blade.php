<div class="card-item group h-full">
    <div class="bg-{{ $cardBackgroundColor }} text-{{ $cardTextColor }} rounded-{{ $borderRadius }} h-full flex flex-col group-hover:-translate-y-4 duration-300 ease-in-out overflow-hidden">
        <div>
            <div class="h-[360px] relative overflow-hidden rounded-t-{{ $borderRadius }}">
                @if($block['data']['block_visual'] == 'featured_image' && $featuredImageId)
                    <a href="{{ $pageUrl }}"
                       class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                    @include('components.image', [
                     'image_id' => $featuredImageId,
                     'size' => 'full',
                     'object_fit' => 'cover',
                     'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                     'alt' => $pageTitle
                  ])
                @elseif ($block['data']['block_visual'] == 'icon' && $pageIcon)
                    <div class="h-full flex justify-center items-center">
                        <i class="relative z-20 text-[200px] fas fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-primary transition-all duration-300 ease-in-out"></i>
                    </div>
                @elseif($block['data']['block_visual'] == 'image' && $imageID)
                    <a href="{{ $pageUrl }}"
                       class="absolute w-full h-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out"></a>
                    @include('components.image', [
                       'image_id' => $imageID,
                       'size' => 'full',
                       'object_fit' => 'cover',
                       'img_class' => 'w-full h-full object-cover transform ease-in-out duration-300 group-hover:scale-110 rounded-t-' . $borderRadius,
                       'alt' => $pageTitle
                    ])
                @endif
            </div>
        </div>
        <div class="h-full flex flex-col gap-y-4 p-8">
            <a href="{{ $pageUrl }}"
               class="relative z-20 h3 font-bold group-hover:text-primary transition-all duration-300 ease-in-out">
                {{ $pageTitle }}
            </a>

            @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && $pageExcerpt)
                <p>{{ $pageExcerpt }}</p>
            @endif

            @if (!empty($visibleElements) && in_array('button', $visibleElements))
                <div class="mt-4 flex items-center flex-wrap">
                    <a href="{{ $pageUrl }}" class="text-primary inline-flex items-center md:mb-2 lg:mb-0">Lees meer
                        <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 group-hover:scale-110 transition duration-300 ease-in-out"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            @endif

        </div>
    </div>
</div>