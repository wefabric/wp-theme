@php
    // Content
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? 'white';
    $text = str_replace('{{page_title}}', get_the_title(), $text);

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $button1Download = $block['data']['button_button_1_download'] ?? false;
    $button1Icon = $block['data']['button_button_1_icon'] ?? '';
    if (!empty($button1Icon)) {
        $iconData = json_decode($button1Icon, true);
        if (isset($iconData['id'], $iconData['style'])) {
            $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }
    }
    $button2Text = $block['data']['button_button_2']['title'] ?? '';
    $button2Link = $block['data']['button_button_2']['url'] ?? '';
    $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
    $button2Color = $block['data']['button_button_2_color'] ?? '';
    $button2Style = $block['data']['button_button_2_style'] ?? '';
    $button2Download = $block['data']['button_button_2_download'] ?? false;
    $button2Icon = $block['data']['button_button_2_icon'] ?? '';
    if (!empty($button2Icon)) {
        $iconData = json_decode($button2Icon, true);
        if (isset($iconData['id'], $iconData['style'])) {
            $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }
    }

    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $customCssClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;

    // Sticky menu
    // Leeg = automatische fallback in JS op het eerste <header>/<footer> element van de pagina.
    $showTargetId = trim($block['data']['show_target_id'] ?? '', " \t\n\r\0\x0B#");
    $hideTargetId = trim($block['data']['hide_target_id'] ?? '', " \t\n\r\0\x0B#");
    $landAboveTarget = $block['data']['land_above_target'] ?? false;
@endphp

@if ($text || $button1Text || $button2Text)
    <section
        id="@if($customBlockId){{ $customBlockId }}@else{{ 'sticky-balk' }}@endif"
        class="block-sticky-balk fixed bottom-0 left-0 z-40 w-full bg-{{ $backgroundColor }} {{ $customCssClasses }} {{ $hideBlock ? 'hidden' : '' }}"
        @if ($backgroundImageId) style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}" @endif
        data-show-target-id="{{ $showTargetId }}"
        data-hide-target-id="{{ $hideTargetId }}"
        data-land-above-target="{{ $landAboveTarget ? 'true' : 'false' }}"
    >
        <div class="sticky-balk-inner container mx-auto flex flex-col gap-4 px-6 py-4 lg:flex-row lg:items-center lg:justify-between lg:gap-8">
            @if ($text)
                <p class="sticky-balk-text mb-0 flex-1 min-w-0 font-bold text-{{ $textColor }}">{{ $text }}</p>
            @endif

            @if ($button1Text || $button2Text)
                <div class="buttons flex flex-shrink-0 flex-wrap items-center gap-3 lg:justify-end">
                    @if ($button1Text && $button1Link)
                        @include('components.buttons.default', [
                            'text' => $button1Text,
                            'href' => $button1Link,
                            'alt' => $button1Text,
                            'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                            'class' => 'rounded-lg',
                            'target' => $button1Target,
                            'icon' => $button1Icon,
                            'download' => $button1Download,
                        ])
                    @endif
                    @if ($button2Text && $button2Link)
                        @include('components.buttons.default', [
                            'text' => $button2Text,
                            'href' => $button2Link,
                            'alt' => $button2Text,
                            'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                            'class' => 'rounded-lg',
                            'target' => $button2Target,
                            'icon' => $button2Icon,
                            'download' => $button2Download,
                        ])
                    @endif
                </div>
            @endif
        </div>
    </section>
@endif
