@php
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp


<div class="steps flex flex-col mx-auto">
    @for ($i = 0; $i < $steps; $i++)
        @php
            $stepTitleKey = "steps_{$i}_step_title";
            $stepTextKey = "steps_{$i}_step_text";

            $stepImageKey = "steps_{$i}_step_image";

            $stepIconKey = "steps_{$i}_step_icon";
            $stepIconColorKey = "steps_{$i}_step_icon_color";

            $stepImage = isset($block['data'][$stepImageKey]) ? $block['data'][$stepImageKey] : '';
            $stepImageAlt = get_post_meta($stepImage, '_wp_attachment_image_alt', true) ?: "Stap " . ($i + 1) . " afbeelding";

            $stepIcon = isset($block['data'][$stepIconKey]) ? $block['data'][$stepIconKey] : '';
            $stepIconColor = isset($block['data'][$stepIconColorKey]) ? $block['data'][$stepIconColorKey] : '';
            $stepTitle = isset($block['data'][$stepTitleKey]) ? $block['data'][$stepTitleKey] : '';
            $stepText = isset($block['data'][$stepTextKey]) ? $block['data'][$stepTextKey] : '';

            $iconData = json_decode($stepIcon);
            $iconClass = '';
            if ($iconData && isset($iconData->style) && isset($iconData->id)) {
                $iconClass = $iconData->style . ' fa-' . $iconData->id;
            }
        @endphp

        <div class="step flex relative py-6 sm:items-center w-full">
            @if (!empty($visibleElements) && in_array('stepnumber_1', $visibleElements))
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-200"></div>
                </div>
                <div class="step-number flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary bg-{{ $stepIconColor }} text-white z-10 text-sm">{{ $i + 1 }}</div>
            @endif
            <div class="step-layout flex flex-col sm:flex-row gap-x-6 gap-y-2 items-start sm:items-center @if (!empty($visibleElements) && in_array('stepnumber_1', $visibleElements)) pl-6 @endif">
                @if ($stepIcon)
                    <div class="flex-shrink-0 w-24 h-24 bg-primary-light bg-{{ $stepIconColor }}-light text-primary text-{{ $stepIconColor }} rounded-full inline-flex items-center justify-center">
                        @if ($iconClass)
                            <i class="fa {{ $iconClass }} text-3xl w-12 h-12 text-center"
                               aria-hidden="true"></i>
                        @endif
                    </div>
                @endif
                @if ($stepImage)
                    <div class="image-container flex-shrink-0">
                        @include('components.image', [
                            'image_id' => $stepImage,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'object-cover md:w-60 rounded-' . $borderRadius,
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

                       <div class="step-number">{{ $translatedStepText }} {{ $i + 1 }}</div>
                    @endif
                    @if($stepTitle)
                        <h3 class="step-title mb-1 text-xl text-{{ $stepTitleColor }}">{!! $stepTitle !!}</h3>
                    @endif
                    @if ($stepText)
                        @include('components.content', ['content' => apply_filters('the_content', $stepText), 'class' => 'text-' . $stepTextColor])
                    @endif
                </div>
            </div>
        </div>
    @endfor
</div>