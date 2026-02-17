<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;
use Theme\Views\SectionStyling;

class Section extends Component
{

    public string $backgroundColor = '';
    public string $backgroundClass = '';
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
        public array $block = [],
        ?int $randomNumber = null
    )
    {
        if ($randomNumber === null) {
            $this->randomNumber = rand(0, 1000);
        } else {
            $this->randomNumber = $randomNumber;
        }
        // Normalize background color: treat 0 / '0' / '' as unset
        $backgroundColorRaw = $block['data']['background_color'] ?? '';
        $hasBackgroundColor = (is_string($backgroundColorRaw) && $backgroundColorRaw !== '' && $backgroundColorRaw !== '0') || (is_int($backgroundColorRaw) && $backgroundColorRaw !== 0);
        $this->backgroundColor = $hasBackgroundColor ? (string)$backgroundColorRaw : '';
        $this->backgroundClass = $this->backgroundColor !== '' ? 'bg-' . $this->backgroundColor : '';

        $this->backgroundImageId = $block['data']['background_image'] ?? '';
        $this->overlayEnabled = $block['data']['overlay_image'] ?? false;
        $this->overlayColor = $block['data']['overlay_color'] ?? '';
        $this->overlayOpacity = $block['data']['overlay_opacity'] ?? '';
        $this->backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

        $this->customBlockClasses = $block['data']['custom_css_classes'] ?? '';
        $this->customBlockId = $block['data']['custom_block_id'] ?? '';
        $this->hideBlock = $block['data']['hide_block'] ?? false;

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
