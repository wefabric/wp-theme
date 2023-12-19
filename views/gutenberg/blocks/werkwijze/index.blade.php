@php
    // Werkwijze variant
    $workflowVariant = $block['data']['layout_steps'] ?? '';

    // Content
    $title = $block['data']['title'];
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    $imageID = $block['data']['image'] ?? '';
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';

    // Show steps
    $steps = $block['data']['steps'];
    $showStepNumber = $block['data']['show_step_number'];
    $stepTitleColor = $block['data']['step_title_color'] ?? '';
    $stepTextColor = $block['data']['step_text_color'] ?? '';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';
@endphp

<section id="werkwijze" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="container mx-auto mb-8 lg:mb-20 {{ $titleClass }} text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif

            <div class="flex flex-col lg:flex-row gap-x-8">
                @if ($imageID)
                    <div class="workflow-image w-full lg:w-1/2">
                        @include('components.image', [
                            'image_id' => $imageID,
                            'size' => 'full',
                            'object_fit' => 'contain',
                            'img_class' => 'object-contain',
                            'alt' => $imageAlt,
                        ])
                    </div>
                @endif
                <div class="custom-layout @if($imageID) w-full lg:w-1/2 @else w-full @endif">
                    @if ($workflowVariant == 'horizontal')
                        @include('components.workflow.workflow-horizontal')
                    @elseif ($workflowVariant == 'vertical')
                        @include('components.workflow.workflow-vertical')
                    @endif

                    @if (($button1Text) && ($button1Link))
                        <div class="w-full flex sm:flex-row gap-4 mt-4 md:mt-8 pl-6 sm:pl-12 md:pl-14">
                            @include('components.buttons.default', [
                               'text' => $button1Text,
                               'href' => $button1Link,
                               'alt' => $button1Text,
                               'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                               'class' => 'rounded-lg',
                               'target' => $button1Target,
                           ])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>