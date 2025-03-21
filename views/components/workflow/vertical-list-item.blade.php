@php
    $stepTitle = $step['stepTitle'];
    $stepText = $step['stepText'];
    $stepNumber = $step['stepNumber'];
    $stepIcon = $step['stepIcon'];
    $stepImage = $step['stepImage'];

    $visualType = $block['data']['visual_type'] ?? '';
@endphp

<div class="step-item step flex relative py-6 sm:items-center w-full @if ($flyinEffect) step-hidden @endif" data-step-image-url="{{ wp_get_attachment_url($stepImage) }}">
    @if (!empty($visibleElements) && in_array('stepnumber_1', $visibleElements))
        <div class="step-number-line h-full w-6 absolute inset-0 flex items-center justify-center">
            <div class="vertical-line h-full w-1 bg-gray-200"></div>
        </div>
        <div class="step-number flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary bg-{{ $stepIconColor }} text-white z-10 text-sm">{{ $stepNumber }}</div>
    @endif
    <div class="step-layout flex flex-col sm:flex-row gap-x-6 gap-y-2 items-start sm:items-center @if (!empty($visibleElements) && in_array('stepnumber_1', $visibleElements)) pl-6 @endif">

        @if ($stepIcon && $visualType == 'icons')
            <div class="mx-auto w-24 h-24 bg-black rounded-full inline-flex items-center justify-center">
                <i class="fa-{{ $stepIcon['style'] }} fa-{{ $stepIcon['id'] }} text-{{ $stepIconColor }} text-3xl w-24 h-12 text-center"
                   aria-hidden="true"></i>
            </div>
        @endif


        @if ($stepImage && $visualType == 'images' && !$specialLayout)
            <div class="image-container flex-shrink-0">
                @include('components.image', [
                    'image_id' => $stepImage,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'object-cover h-60 w-60 rounded-' . $borderRadius,
                    'alt' => $stepImageAlt,
                ])
            </div>
        @endif
        <div class="step-data flex-grow">
            @if (!empty($visibleElements) && in_array('stepnumber_2', $visibleElements))
                {{-- Translation for hardcoded text--}}
                @php
                    $translatedStepText = 'Stap';
                    $current_language = get_locale();
                        if ($current_language == 'en_EN' || $current_language == 'en_GB') {
                            $translatedStepText = 'Step';
                        } else {
                            $translatedStepText = 'Stap';
                        }
                @endphp

                <div class="step-number">{{ $translatedStepText }} {{ $stepNumber }}</div>
            @endif
            @if($stepTitle)
                <div class="step-title mb-1 text-xl text-{{ $stepTitleColor }}">{!! $stepTitle !!}</div>
            @endif
            @if ($stepText)
                @include('components.content', ['content' => apply_filters('the_content', $stepText), 'class' => 'text-' . $stepTextColor])
            @endif
        </div>
    </div>
</div>

