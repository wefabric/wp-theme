<div id="{{ str_replace(' ', '-', strtolower($pageTitle)) }}" class="content-in-card-item card-item group h-full w-full">
    <div class="card-background p-6 xl:p-8 h-full mx-auto relative bg-{{ $cardBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-center text-center rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"
        @if ($block['data']['block_visual'] == 'featured_image' && $featuredImageId)
             style="background-image: url('{{ wp_get_attachment_image_url($featuredImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($featuredImageId) }}">
        @elseif ($block['data']['block_visual'] == 'image' && $imageID)
             style="background-image: url('{{ wp_get_attachment_image_url($imageID, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageID) }}">
        @else >
        @endif

        <a href="{{ $pageUrl }}"
           class="card-overlay left-0 right-0 absolute h-full w-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>
        @if ($pageIcon)
            <a class="page-icon" href="{{ $pageUrl }}">
                <i class="text-{{ $cardTitleColor }} page-icon relative z-20 text-[60px] md:text-[100px] fa-{{ $pageIcon['style'] }} fa-{{ $pageIcon['id'] }} group-hover:scale-110 group-hover:text-white transition-all duration-300 ease-in-out"></i>
            </a>
        @endif
        <a href="{{ $pageUrl }}"
           class="text-{{ $cardTitleColor }} page-title relative z-20 h4 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
            {{ $pageTitle }}
        </a>
        @if (!empty($visibleElements) && in_array('overview_text', $visibleElements) && $pageExcerpt)
            <p class="text-{{ $cardTextColor }} relative z-20 group-hover:text-white transition-all duration-300 ease-in-out">{{ $pageExcerpt }}</p>
        @endif
        @if (!empty($visibleElements) && in_array('button', $visibleElements))
            @if ($buttonCardText)
                <div class="page-button relative z-20 flex items-center">
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