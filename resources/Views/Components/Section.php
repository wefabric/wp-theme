<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;
use Theme\Views\SectionStyling;

class Section extends Component
{

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

    public ?SectionStyling $styling = null;

    public function __construct(
        public string $blockType,
        public array $block = []
    )
    {
        $this->backgroundColor = $block['data']['background_color'] ?? 'default-color';
        $this->backgroundImageId = $block['data']['background_image'] ?? '';
        $this->overlayEnabled = $block['data']['overlay_image'] ?? false;
        $this->overlayColor = $block['data']['overlay_color'] ?? '';
        $this->overlayOpacity = $block['data']['overlay_opacity'] ?? '';
        $this->backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

        $this->customBlockClasses = $block['data']['custom_css_classes'] ?? '';
        $this->customBlockId = $block['data']['custom_block_id'] ?? '';
        $this->hideBlock = $block['data']['hide_block'] ?? false;

        $this->randomNumber = rand(0, 1000);
        $this->styling = SectionStyling::fromBlockData($this->block);
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
