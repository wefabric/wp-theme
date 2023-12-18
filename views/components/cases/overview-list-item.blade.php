@php
    $fields = get_fields($case);

    $caseQuote = $fields['case_quote'] ?? '';
    $caseText = $fields['case_text'] ?? '';
    $caseTitle = get_the_title($case);
    $caseLogo = $fields['logo'] ?? '';
    $caseImage = $fields['case_image'] ?? '';
    $caseUrl = get_permalink($case);

    // Weergave
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

<div class="klantcase-item group h-full w-full text-{{ $caseTextColor }}">
    <div class="card-background p-6 xl:p-8 h-full mx-auto relative bg-{{ $caseBackgroundColor }} w-full aspect-square flex flex-col gap-y-4 items-center justify-center text-center rounded-{{ $borderRadius }} group-hover:-translate-y-4 duration-300 ease-in-out"

         @if ($caseImage)
             style="background-image: url('{{ wp_get_attachment_image_url($caseImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($caseImage) }}">
        @endif

        <a href="{{ $caseUrl }}" aria-label="Ga naar {{ $caseTitle }} pagina"
           class="card-overlay left-0 right-0 absolute h-full w-full bg-primary z-10 opacity-0 group-hover:opacity-50 transition-opacity duration-300 ease-in-out rounded-{{ $borderRadius }}"></a>

        <a href="{{ $caseUrl }} " aria-label="Ga naar {{ $caseTitle }} pagina"
           class="text-{{ $caseTextColor }} page-title relative z-20 h3 font-bold group-hover:text-white transition-all duration-300 ease-in-out">
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
                   ])
                </div>
            @endif
        @endif

    </div>
</div>
