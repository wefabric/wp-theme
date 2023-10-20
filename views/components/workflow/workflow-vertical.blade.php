<div class="flex flex-wrap mx-auto">
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

        <div class="flex relative pt-10 pb-20 sm:items-center w-full">
            @if ($showStepNumber)
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-200"></div>
                </div>
                <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary bg-{{ $stepIconColor }} text-white z-10 text-sm">{{ $i + 1 }}</div>
            @endif
            <div class="flex flex-col sm:flex-row pl-6 md:pl-8 items-start sm:items-center">
                @if ($stepIcon)
                    <div class="flex-shrink-0 w-24 h-24 bg-primary-light bg-{{ $stepIconColor }}-light text-primary text-{{ $stepIconColor }} rounded-full inline-flex items-center justify-center">
                        @if ($iconClass)
                            <i class="fa {{ $iconClass }} text-3xl w-12 h-12 text-center"
                               aria-hidden="true"></i>
                        @endif
                    </div>
                @endif
                @if ($stepImage)
                    <div class="flex-shrink-0">
                        @include('components.image', [
                            'image_id' => $stepImage,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'object-cover md:w-60 rounded-' . $borderRadius,
                            'alt' => $stepImageAlt,
                        ])
                    </div>
                @endif
                <div class="flex-grow sm:pl-6 mt-6 sm:mt-0 text-{{ $stepTextColor }}">
                    <h3 class="mb-1 text-xl">{{ $stepTitle }}</h3>
                    <p class="">{{ $stepText }}</p>
                </div>
            </div>
        </div>
    @endfor
</div>