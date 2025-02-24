@php
    $fields = get_fields($case);

    $caseQuote = $fields['case_quote'] ?? '';
    $caseText = $fields['case_text'] ?? '';
    $caseTitle = get_the_title($case);
    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';
    $caseUrl = get_permalink($case);
    $caseExcerpt = get_the_excerpt($case);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

<div class="klantcase-item group h-full w-full @if ($flyinEffect) klantencase-hidden @endif">
    <div class="card-background p-6 xl:p-8 h-full mx-auto relative bg-{{ $caseBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-end text-center overflow-hidden rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"

         @if ($caseImage)
             style="background-image: url('{{ wp_get_attachment_image_url($caseImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($caseImage) }}">
        @endif

        <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina" class="card-overlay absolute bottom-0 w-full opacity-80 transition-all duration-300 ease-in-out group-hover:h-full h-3/5 sm:h-1/2 lg:h-2/5 bg-primary rounded-b-{{ $borderRadius }} group-hover:rounded-t-{{ $borderRadius }}"></a>
        @if($caseExcerpt)
            <a href="{{ $caseUrl }} " aria-label="Ga naar {{ $caseTitle }} pagina" class="hidden lg:block text-{{ $caseTextColor }} absolute z-20 -translate-x-1/2 -translate-y-full left-1/2 top-1/2 opacity-0 group-hover:opacity-100 h5 transition-all duration-300 ease-in-out">{{ $caseExcerpt }}</a>
        @endif

        <a href="{{ $caseUrl }} " aria-label="Ga naar {{ $caseTitle }} pagina"
           class="text-{{ $caseTextColor }} page-title text-{{ $caseTextColor }} relative z-20 h3 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
            {!! $caseTitle !!}
        </a>

        @if (!empty($visibleElements) && in_array('button', $visibleElements))
            @if ($buttonCardText)
                <div class="page-button relative z-20 flex items-center">
                    @include('components.buttons.default', [
                       'text' => $buttonCardText,
                       'href' => $caseUrl,
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
