@php
    $title = $block['data']['title'];
    $titlePosition = $block['data']['title_position'] ?? '';
    $backgroundColor = $block['data']['background_color'] ?? 'none';

     $titleClass = '';
        if ($titlePosition === 'left') {
            $titleClass = 'text-left';
        } elseif ($titlePosition === 'center') {
            $titleClass = 'text-center';
        } elseif ($titlePosition === 'right') {
            $titleClass = 'text-right';
        }

    $steps = $block['data']['steps'];
    $showStepNumber = $block['data']['show_step_number'];



    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClass = '';
    if ($blockWidth == 50) {
        $blockClass = 'w-full lg:w-1/2';
    }
    elseif ($blockWidth == 66) {
        $blockClass = 'w-full lg:w-2/3';
    }
    elseif ($blockWidth == 100) {
        $blockClass = ' w-full';
    }
    elseif ($blockWidth == 'fullscreen') {
        $blockClass = 'w-full';
    }

    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';
@endphp

<section id="werknemers-block" class="bg-{{ $backgroundColor}}">
    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20">
        <div class="{{ $blockClass }} mx-auto">
            <h2 class="container mx-auto mb-8 lg:mb-20 {{ $titleClass }}">{{ $title }}</h2>

            <div class="flex flex-wrap mx-auto">
                @for ($i = 0; $i < $steps; $i++)
                    @php

                        $stepTitleKey = "steps_{$i}_step_title";
                        $stepTextKey = "steps_{$i}_step_text";

                        $stepImageKey = "steps_{$i}_step_image";

                        $stepIconKey = "steps_{$i}_step_icon";
                        $stepIconColorKey = "steps_{$i}_step_icon_color";

                        $stepImage = isset($block['data'][$stepImageKey]) ? $block['data'][$stepImageKey] : '';

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
                                <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                            </div>
                            <div class="flex-shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-primary bg-{{ $stepIconColor }} text-white z-10 text-sm">{{ $i + 1 }}</div>
                        @endif

                        <div class="flex-grow md:pl-8 pl-6 flex sm:items-center items-start flex-col sm:flex-row">

                            @if ($stepIcon)
                                <div class="flex-shrink-0 w-24 h-24 bg-primary-light bg-{{ $stepIconColor }}-light text-primary text-{{ $stepIconColor }} rounded-full inline-flex items-center justify-center">
                                    @if ($iconClass)
                                        <i class="fa {{ $iconClass }} text-3xl w-12 h-12 text-center" aria-hidden="true"></i>
                                    @endif
                                </div>
                            @endif

                            @if ($stepImage)
                                <div class="flex-shrink-0">
                                    <img src="{{ wp_get_attachment_image_url($stepImage, 'full') }}" alt="Step Image" class="object-cover md:w-60">
                                </div>
                            @endif

                            <div class="flex-grow sm:pl-6 mt-6 sm:mt-0">
                                <h3 class="mb-1 text-xl">{{ $stepTitle }}</h3>
                                <p class="">{{ $stepText }}</p>
                            </div>

                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</section>