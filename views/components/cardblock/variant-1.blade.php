<div class="card-item group h-full">
    <div class="relative bg-{{ $cardBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-center text-center text-{{ $cardTextColor }} rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"
         @if ($block['data']['block_visual'] == 'featured_image' && $featuredImageId)
             style="background-image: url('{{ wp_get_attachment_image_url($featuredImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;"
         @elseif ($block['data']['block_visual'] == 'image' && $imageID)
             style="background-image: url('{{ wp_get_attachment_image_url($imageID, 'full') }}'); background-repeat: no-repeat; background-size: cover;"
            @endif
    >

        <a href="{{ $pageUrl }}"
           class="absolute h-full w-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out rounded-t-{{ $borderRadius }}"></a>
        @if ($pageIcon)
            <a href="{{ $pageUrl }}">
                <i class="relative z-20 text-[60px] md:text-[100px] fas fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-white transition-all duration-300 ease-in-out"></i>
            </a>
        @endif
        <a href="{{ $pageUrl }}"
           class="relative z-20 h4 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
            {{ $pageTitle }}
        </a>
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && $pageExcerpt)
            <p class="relative z-20 group-hover:text-white transition-all duration-300 ease-in-out">{{ $pageExcerpt }}</p>
        @endif
        @if (!empty($visibleElements) && in_array('button', $visibleElements))
            <div class="relative z-20 flex items-center">
                <a href="{{ $pageUrl }}"
                   class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">Lees meer</a>
            </div>
        @endif
    </div>
</div>