@php
    $ctaTitle = $block['data']['cta_title'] ?? '';
    $ctaTitleColor = $block['data']['cta_title_color'] ?? '';
    $ctaSubtitle = $block['data']['cta_subtitle'] ?? '';
    $ctaSubtitleColor = $block['data']['cta_subtitle_color'] ?? '';
    $ctaText = $block['data']['cta_text'] ?? '';
    $ctaTextColor = $block['data']['cta_text_color'] ?? '';

    $ctaButtonText = $block['data']['cta_button']['title'] ?? '';
    $ctaButtonLink = $block['data']['cta_button']['url'] ?? '';
    $ctaButtonTarget = $block['data']['cta_button']['target'] ?? '_self';
    $ctaButtonColor = $block['data']['cta_button_color'] ?? 'primary-color';
    $ctaButtonStyle = $block['data']['cta_button_style'] ?? 'filled';
    $ctaButtonIcon = $block['data']['cta_button_icon'] ?? '';
    if (!empty($ctaButtonIcon)) {
        $iconData = json_decode($ctaButtonIcon, true);
        if (isset($iconData['id'], $iconData['style'])) {
            $ctaButtonIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }
    }

    $ctaBackgroundColor = $block['data']['cta_background_color'] ?? '';
    $ctaBackgroundImageId = $block['data']['cta_background_image'] ?? '';
    $ctaColumnSpan = $block['data']['cta_column_span'] ?? '1';
@endphp

<div class="vacature-item vacature-cta-item group h-full {{ $ctaColumnSpan == '2' ? 'sm:col-span-2' : '' }} @if ($flyinEffect) vacancy-hidden @endif">
    <div class="custom-styling h-full flex flex-col justify-center p-8 relative overflow-hidden bg-{{ $ctaBackgroundColor }}"
         style="@if($ctaBackgroundImageId) background-image: url('{{ wp_get_attachment_image_url($ctaBackgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($ctaBackgroundImageId) }} @endif">
        <div class="vacature-cta-content relative z-10">
            @if ($ctaSubtitle)
                <span class="vacature-cta-subtitle block mb-2 text-{{ $ctaSubtitleColor }}">{!! $ctaSubtitle !!}</span>
            @endif
            @if ($ctaTitle)
                <h3 class="vacature-cta-title font-bold text-lg mb-3 text-{{ $ctaTitleColor }}">{!! $ctaTitle !!}</h3>
            @endif
            @if ($ctaText)
                @include('components.content', [
                    'content' => apply_filters('the_content', $ctaText),
                    'class' => 'vacature-cta-text mb-4 text-' . $ctaTextColor,
                ])
            @endif
            @if ($ctaButtonText && $ctaButtonLink)
                @include('components.buttons.default', [
                    'text' => $ctaButtonText,
                    'href' => $ctaButtonLink,
                    'alt' => $ctaButtonText,
                    'colors' => 'btn-' . $ctaButtonColor . ' btn-' . $ctaButtonStyle,
                    'class' => 'rounded-lg',
                    'target' => $ctaButtonTarget,
                    'icon' => $ctaButtonIcon,
                ])
            @endif
        </div>
    </div>
</div>
