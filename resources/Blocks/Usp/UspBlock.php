<?php

namespace Theme\Blocks\Usp;

use Theme\Helpers\AcfRepeater;

class UspBlock
{
    // Content
    public readonly string $title;
    public readonly string $titleColor;
    public readonly string $subTitle;
    public readonly string $subTitleColor;
    public readonly ?array $subtitleIcon;
    public readonly string $subtitleIconColor;
    public readonly string $text;
    public readonly string $textColor;

    // Buttons
    public readonly string $button1Text;
    public readonly string $button1Link;
    public readonly string $button1Target;
    public readonly string $button1Color;
    public readonly string $button1Style;
    public readonly bool $button1Download;
    public readonly string $button1Icon;
    public readonly string $button2Text;
    public readonly string $button2Link;
    public readonly string $button2Target;
    public readonly string $button2Color;
    public readonly string $button2Style;
    public readonly bool $button2Download;
    public readonly string $button2Icon;
    public readonly string $buttonPosition;
    public readonly string $textPosition;
    public readonly string $textClass;

    // USPs
    public readonly string $uspTitleColor;
    public readonly string $uspTextColor;
    public readonly string $uspBackgroundColor;
    public readonly string $uspIconColor;
    public readonly string $uspLayout;
    public readonly string $visualType;
    public readonly bool $numberAnimation;

    /** @var UspItem[] */
    public readonly array $usps;

    // Slider / grid
    public readonly bool $showSlider;
    public readonly bool $swiperOutContainer;
    public readonly bool $swiperAutoplay;
    public readonly int $swiperAutoplaySpeed;
    public readonly bool $swiperLoop;
    public readonly bool $swiperCenteredSlides;
    public readonly int $mobileLayout;
    public readonly int $tabletLayout;
    public readonly int $desktopLayout;
    public readonly int $desktopXlLayout;

    // Block settings
    public readonly int|string $blockWidth;
    public readonly string $blockClass;
    public readonly string $fullScreenClass;
    public readonly string $backgroundColor;
    public readonly string $backgroundImageId;
    public readonly bool $overlayEnabled;
    public readonly string $overlayColor;
    public readonly string $overlayOpacity;
    public readonly bool $backgroundImageParallax;
    public readonly string $customBlockClasses;
    public readonly string $customBlockId;
    public readonly bool $hideBlock;

    // Paddings
    public readonly string $mobilePaddingTop;
    public readonly string $mobilePaddingRight;
    public readonly string $mobilePaddingBottom;
    public readonly string $mobilePaddingLeft;
    public readonly string $tabletPaddingTop;
    public readonly string $tabletPaddingRight;
    public readonly string $tabletPaddingBottom;
    public readonly string $tabletPaddingLeft;
    public readonly string $desktopPaddingTop;
    public readonly string $desktopPaddingRight;
    public readonly string $desktopPaddingBottom;
    public readonly string $desktopPaddingLeft;

    // Margins
    public readonly string $mobileMarginTop;
    public readonly string $mobileMarginRight;
    public readonly string $mobileMarginBottom;
    public readonly string $mobileMarginLeft;
    public readonly string $tabletMarginTop;
    public readonly string $tabletMarginRight;
    public readonly string $tabletMarginBottom;
    public readonly string $tabletMarginLeft;
    public readonly string $desktopMarginTop;
    public readonly string $desktopMarginRight;
    public readonly string $desktopMarginBottom;
    public readonly string $desktopMarginLeft;

    // Animation
    public readonly bool $flyinEffect;

    public function __construct(array $block)
    {
        $data = $block['data'] ?? [];

        // Content
        $this->title = $data['title'] ?? '';
        $this->titleColor = $data['title_color'] ?? '';
        $this->subTitle = $data['subtitle'] ?? '';
        $this->subTitleColor = $data['subtitle_color'] ?? '';
        $rawSubtitleIcon = $data['subtitle_icon'] ?? '';
        $this->subtitleIcon = $rawSubtitleIcon ? json_decode($rawSubtitleIcon, true) : null;
        $this->subtitleIconColor = $data['subtitle_icon_color'] ?? '';
        $this->text = $data['text'] ?? '';
        $this->textColor = $data['text_color'] ?? '';

        // Buttons
        $this->button1Text = $data['button_button_1']['title'] ?? '';
        $this->button1Link = $data['button_button_1']['url'] ?? '';
        $this->button1Target = $data['button_button_1']['target'] ?? '_self';
        $this->button1Color = $data['button_button_1_color'] ?? '';
        $this->button1Style = $data['button_button_1_style'] ?? '';
        $this->button1Download = (bool) ($data['button_button_1_download'] ?? false);
        $this->button1Icon = $this->parseIconClass($data['button_button_1_icon'] ?? '');
        $this->button2Text = $data['button_button_2']['title'] ?? '';
        $this->button2Link = $data['button_button_2']['url'] ?? '';
        $this->button2Target = $data['button_button_2']['target'] ?? '_self';
        $this->button2Color = $data['button_button_2_color'] ?? '';
        $this->button2Style = $data['button_button_2_style'] ?? '';
        $this->button2Download = (bool) ($data['button_button_2_download'] ?? false);
        $this->button2Icon = $this->parseIconClass($data['button_button_2_icon'] ?? '');
        $this->buttonPosition = $data['button_position'] ?? 'bottom';
        $this->textPosition = $data['text_position'] ?? '';
        $this->textClass = [
            'left' => 'text-left justify-start',
            'center' => 'text-center justify-center',
            'right' => 'text-right justify-end',
        ][$this->textPosition] ?? '';

        // USPs
        $this->uspTitleColor = $data['usp_title_color'] ?? '';
        $this->uspTextColor = $data['usp_text_color'] ?? '';
        $this->uspBackgroundColor = $data['usp_background_color'] ?? '';
        $this->uspIconColor = $data['usp_icon_color'] ?? '';
        $this->uspLayout = $data['usp_layout'] ?? 'vertical';
        $this->visualType = $data['visual_type'] ?? 'icons';
        $this->numberAnimation = (bool) ($data['number_animation'] ?? false);
        $this->usps = array_map(
            fn(array $row) => new UspItem(
                title: $row['usp_title'] ?? '',
                text: $row['usp_text'] ?? '',
                link: is_array($row['usp_link'] ?? null) ? $row['usp_link'] : null,
                image: $row['image'] ?? '',
                rawIcon: $row['icon'] ?? null,
            ),
            AcfRepeater::parse($data, 'usps')
        );

        // Slider / grid
        $this->showSlider = (bool) ($data['show_slider'] ?? false);
        $this->swiperOutContainer = (bool) ($data['slider_outside_container'] ?? false);
        $this->swiperAutoplay = (bool) ($data['autoplay'] ?? false);
        $this->swiperAutoplaySpeed = max((int) (($data['autoplay_speed'] ?? 0) * 1000), 5000);
        $this->swiperLoop = (bool) ($data['loop_slides'] ?? true);
        $this->swiperCenteredSlides = (bool) ($data['centered_slides'] ?? false);
        $this->mobileLayout = (int) ($data['layout_mobile'] ?? 3);
        $this->tabletLayout = (int) ($data['layout_tablet'] ?? 3);
        $this->desktopLayout = (int) ($data['layout_desktop'] ?? 3);
        $this->desktopXlLayout = (int) ($data['layout_desktop_xl'] ?? 4);

        // Block settings
        $this->blockWidth = $data['block_width'] ?? 100;
        $this->blockClass = [
            50 => 'w-full lg:w-1/2',
            66 => 'w-full lg:w-2/3',
            80 => 'w-full lg:w-4/5',
            100 => 'w-full',
            'fullscreen' => 'w-full',
        ][$this->blockWidth] ?? '';
        $this->fullScreenClass = $this->blockWidth !== 'fullscreen' ? 'container mx-auto' : '';
        $this->backgroundColor = $data['background_color'] ?? 'none';
        $this->backgroundImageId = $data['background_image'] ?? '';
        $this->overlayEnabled = (bool) ($data['overlay_image'] ?? false);
        $this->overlayColor = $data['overlay_color'] ?? '';
        $this->overlayOpacity = $data['overlay_opacity'] ?? '';
        $this->backgroundImageParallax = (bool) ($data['background_image_parallax'] ?? false);
        $this->customBlockClasses = $data['custom_css_classes'] ?? '';
        $this->customBlockId = $data['custom_block_id'] ?? '';
        $this->hideBlock = (bool) ($data['hide_block'] ?? false);

        // Paddings
        $this->mobilePaddingTop = $data['padding_mobile_padding_top'] ?? '';
        $this->mobilePaddingRight = $data['padding_mobile_padding_right'] ?? '';
        $this->mobilePaddingBottom = $data['padding_mobile_padding_bottom'] ?? '';
        $this->mobilePaddingLeft = $data['padding_mobile_padding_left'] ?? '';
        $this->tabletPaddingTop = $data['padding_tablet_padding_top'] ?? '';
        $this->tabletPaddingRight = $data['padding_tablet_padding_right'] ?? '';
        $this->tabletPaddingBottom = $data['padding_tablet_padding_bottom'] ?? '';
        $this->tabletPaddingLeft = $data['padding_tablet_padding_left'] ?? '';
        $this->desktopPaddingTop = $data['padding_desktop_padding_top'] ?? '';
        $this->desktopPaddingRight = $data['padding_desktop_padding_right'] ?? '';
        $this->desktopPaddingBottom = $data['padding_desktop_padding_bottom'] ?? '';
        $this->desktopPaddingLeft = $data['padding_desktop_padding_left'] ?? '';

        // Margins
        $this->mobileMarginTop = $data['margin_mobile_margin_top'] ?? '';
        $this->mobileMarginRight = $data['margin_mobile_margin_right'] ?? '';
        $this->mobileMarginBottom = $data['margin_mobile_margin_bottom'] ?? '';
        $this->mobileMarginLeft = $data['margin_mobile_margin_left'] ?? '';
        $this->tabletMarginTop = $data['margin_tablet_margin_top'] ?? '';
        $this->tabletMarginRight = $data['margin_tablet_margin_right'] ?? '';
        $this->tabletMarginBottom = $data['margin_tablet_margin_bottom'] ?? '';
        $this->tabletMarginLeft = $data['margin_tablet_margin_left'] ?? '';
        $this->desktopMarginTop = $data['margin_desktop_margin_top'] ?? '';
        $this->desktopMarginRight = $data['margin_desktop_margin_right'] ?? '';
        $this->desktopMarginBottom = $data['margin_desktop_margin_bottom'] ?? '';
        $this->desktopMarginLeft = $data['margin_desktop_margin_left'] ?? '';

        // Animation
        $this->flyinEffect = (bool) ($data['flyin_effect'] ?? false);
    }

    private function parseIconClass(string $rawIcon): string
    {
        if (empty($rawIcon)) {
            return '';
        }

        $iconData = json_decode($rawIcon, true);

        if (isset($iconData['id'], $iconData['style'])) {
            return 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
        }

        return $rawIcon;
    }
}
