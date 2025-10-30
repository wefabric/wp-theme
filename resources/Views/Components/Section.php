<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;

class Section extends Component
{

    public int $blockWidth = 100;
    public array $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    public string $blockClass = '';
    public string $fullScreenClass = '';
    public string $backgroundColor = 'default-color';
    public string $backgroundImageId = '';
    public bool $overlayEnabled = false;
    public string $overlayColor = '';
    public string $overlayOpacity = '';
    public bool $backgroundImageParallax = false;
    public string $customBlockClasses = '';
    public string $customBlockId = '';
    public bool $hideBlock = false;
    public int $randomNumber = 0;

    public array $paddings = [
        'mobile' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ],
        'tablet' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ],
        'desktop' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ]
    ];

    public array $margins = [
        'mobile' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ],
        'tablet' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ],
        'desktop' => [
            'top' => '',
            'right' => '',
            'bottom' => '',
            'left' => '',
        ]
    ];

    public function __construct(
        public string $blockType,
        public array $block = []
    )
    {
        $this->blockWidth = $block['data']['block_width'] ?? 100;
        $this->blockClass = $this->blockClassMap[$this->blockWidth] ?? '';

        $this->fullScreenClass = $this->blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

        $this->backgroundColor = $block['data']['background_color'] ?? 'default-color';
        $this->backgroundImageId = $block['data']['background_image'] ?? '';
        $this->overlayEnabled = $block['data']['overlay_image'] ?? false;
        $this->overlayColor = $block['data']['overlay_color'] ?? '';
        $this->overlayOpacity = $block['data']['overlay_opacity'] ?? '';
        $this->backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

        $this->customBlockClasses = $block['data']['custom_css_classes'] ?? '';
        $this->customBlockId = $block['data']['custom_block_id'] ?? '';
        $this->hideBlock = $block['data']['hide_block'] ?? false;


        // Paddings & margins
        $this->randomNumber = rand(0, 1000);

        $this->paddings['mobile']['top'] = $block['data']['padding_mobile_padding_top'] ?? '';
        $this->paddings['mobile']['right'] = $block['data']['padding_mobile_padding_right'] ?? '';
        $this->paddings['mobile']['bottom'] = $block['data']['padding_mobile_padding_bottom'] ?? '';
        $this->paddings['mobile']['left'] = $block['data']['padding_mobile_padding_left'] ?? '';
        $this->paddings['tablet']['top'] = $block['data']['padding_tablet_padding_top'] ?? '';
        $this->paddings['tablet']['right'] = $block['data']['padding_tablet_padding_right'] ?? '';
        $this->paddings['tablet']['bottom'] = $block['data']['padding_tablet_padding_bottom'] ?? '';
        $this->paddings['tablet']['left'] = $block['data']['padding_tablet_padding_left'] ?? '';
        $this->paddings['desktop']['top'] = $block['data']['padding_desktop_padding_top'] ?? '';
        $this->paddings['desktop']['right'] = $block['data']['padding_desktop_padding_right'] ?? '';
        $this->paddings['desktop']['bottom'] = $block['data']['padding_desktop_padding_bottom'] ?? '';
        $this->paddings['desktop']['left'] = $block['data']['padding_desktop_padding_left'] ?? '';


        $this->margins['mobile']['top'] = $block['data']['margin_mobile_margin_top'] ?? '';
        $this->margins['mobile']['right'] = $block['data']['margin_mobile_margin_right'] ?? '';
        $this->margins['mobile']['bottom'] = $block['data']['margin_mobile_margin_bottom'] ?? '';
        $this->margins['mobile']['left'] = $block['data']['margin_mobile_margin_left'] ?? '';
        $this->margins['tablet']['top'] = $block['data']['margin_tablet_margin_top'] ?? '';
        $this->margins['tablet']['right'] = $block['data']['margin_tablet_margin_right'] ?? '';
        $this->margins['tablet']['bottom'] = $block['data']['margin_tablet_margin_bottom'] ?? '';

        $this->margins['desktop']['top'] = $block['data']['margin_desktop_margin_top'] ?? '';
        $this->margins['desktop']['right'] = $block['data']['margin_desktop_margin_right'] ?? '';
        $this->margins['desktop']['bottom'] = $block['data']['margin_desktop_margin_bottom'] ?? '';
        $this->margins['desktop']['left'] = $block['data']['margin_desktop_margin_left'] ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.sections.index');
    }
}
