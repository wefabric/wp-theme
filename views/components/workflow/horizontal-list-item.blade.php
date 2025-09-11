@php
    $stepTitle = $step['stepTitle'];
    $stepText = $step['stepText'];
    $stepNumber = $step['stepNumber'];
    $stepIcon = $step['stepIcon'];
    $stepImage = $step['stepImage'];
    $stepLink = $step['stepLink'];

    // Button
    $stepButtonText = $step['stepButtonText'];
    $stepButtonLink = $step['stepButtonLink'];
    $stepButtonTarget = $step['stepButtonTarget'];
    $stepButtonColor = $step['stepButtonColor'];
    $stepButtonStyle = $step['stepButtonStyle'];
    $stepButtonIcon = $step['stepButtonIcon'];

    $visualType = $block['data']['visual_type'] ?? '';
@endphp


<div class="step-item step relative flex flex-col sm:items-center gap-y-8 @if ($flyinEffect) step-hidden @endif">
    @if (!empty($visibleElements) && in_array('stepnumber_2', $visibleElements))
        <div class="step-number-layout w-full flex items-center justify-center relative">
            <div class="step-number flex-shrink-0 w-36 h-36 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary text-white z-10 text-3xl">{{ $stepNumber }}</div>
            @if ($stepNumber < count($steps))
                <div class="workflow-connector hidden lg:flex absolute top-1/2 h-1 w-full items-center justify-center">
                    <i class="fa-solid fa-chevron-right text-3xl text-primary"></i>
                </div>
            @endif
        </div>
    @endif
    <div class="step-item-layout flex flex-col items-center gap-y-4">

        @if ($stepIcon && $visualType == 'icons')
            <div class="mx-auto w-24 h-24 bg-primary-light text-primary rounded-full inline-flex items-center justify-center">
                <i class="fa-{{ $stepIcon['style'] }} fa-{{ $stepIcon['id'] }} text-{{ $stepIconColor }} text-3xl w-12 h-12 text-center"
                   aria-hidden="true"></i>
            </div>
        @endif

        @if ($stepImage && $visualType == 'images')
            <div class="step-image aspect-square">
                @include('components.image', [
                   'image_id' => $stepImage,
                   'size' => 'full',
                   'object_fit' => 'cover',
                   'img_class' => 'object-cover w-32 h-32 aspect-square rounded-' . $borderRadius,
                   'alt' => $stepImageAlt,
               ])
            </div>
        @endif
        <div class="step-content text-center">
            @if($stepTitle)
                @if($stepLink)
                    <a href="{{ $stepLink['url'] }}" aria-label="{{ $stepLink['title'] ?? ('Ga naar ' . $stepTitle) }}">
                        @endif
                        <div class="step-title mb-2 text-xl text-{{ $stepTitleColor }}">{{ $stepTitle }}</div>
                        @if($stepLink)
                    </a>
                @endif
            @endif
            @if ($stepText)
                @include('components.content', ['content' => apply_filters('the_content', $stepText), 'class' => 'text-' . $stepTextColor])
            @endif
            @if ($stepButtonText)
                <div class="step-button mt-auto pt-2 z-10">
                    @include('components.buttons.default', [
                      'text' => $stepButtonText,
                      'href' => $stepButtonLink,
                      'alt' => $stepButtonText,
                      'colors' => 'btn-' . $stepButtonColor . ' btn-' . $stepButtonStyle,
                      'class' => 'rounded-lg',
                      'target' => $stepButtonTarget,
                      'icon' => $stepButtonIcon,
                    ])
                </div>
            @endif
        </div>
    </div>
</div>

