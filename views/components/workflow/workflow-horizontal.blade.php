@php
    $visibleElements = $block['data']['show_element'] ?? [];
@endphp

<div class="steps grid grid-cols-2 lg:grid-cols-4 mx-auto gap-y-16 gap-x-8 lg:gap-x-16">
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

        <div class="step relative flex flex-col sm:items-center gap-y-8">
            @if (!empty($visibleElements) && in_array('stepnumber_1', $visibleElements))
                <div class="w-full flex items-center justify-center relative">
                    <div class="step-number flex-shrink-0 w-36 h-36 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary bg-{{ $stepIconColor }} text-white z-10 text-3xl">{{ $i + 1 }}</div>
                    @if ($i < $steps - 1)
                        <div class="hidden lg:flex worflow-connector absolute top-1/2 h-1 w-full items-center justify-center">
                            <i class="fa-solid fa-chevron-right text-3xl text-primary"></i>
                        </div>
                    @endif
                </div>
            @endif
            <div class="flex flex-col items-center gap-y-4">
                @if ($stepIcon)
                    <div class="mx-auto w-24 h-24 bg-primary-light bg-{{ $stepIconColor }}-light text-primary text-{{ $stepIconColor }} rounded-full inline-flex items-center justify-center">
                        @if ($iconClass)
                            <i class="fa {{ $iconClass }} text-3xl w-12 h-12 text-center"
                               aria-hidden="true"></i>
                        @endif
                    </div>
                @endif
                @if ($stepImage)
                    <div class="aspect-square">
                        @include('components.image', [
                           'image_id' => $stepImage,
                           'size' => 'full',
                           'object_fit' => 'cover',
                           'img_class' => 'object-cover aspect-square rounded-' . $borderRadius,
                           'alt' => $stepImageAlt,
                       ])
                    </div>
                @endif
                <div class="text-center">
                    @if($stepTitle)
                        <h3 class="mb-2 text-xl text-{{ $stepTitleColor }}">{{ $stepTitle }}</h3>
                    @endif
                    @if ($stepText)
                        @include('components.content', ['content' => apply_filters('the_content', $stepText), 'class' => 'text-' . $stepTextColor])
                    @endif
                </div>
            </div>
        </div>
    @endfor
</div>