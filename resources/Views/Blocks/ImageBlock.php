<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;

class ImageBlock extends BlockComponent
{
    use HasTextContent;

    public $imageId;
    public $imageAlt;
    public $maxHeight;
    public $maxWidth;
    public $imageStyle;
    public $overlayEnabled;
    public $overlayColor;
    public $overlayOpacity;
    public $imageParallax;
    public $parallaxStrength;

    public function setBlockData(): void
    {
        $this->setTextContentData();
        $this->imageId = $this->block['data']['image'] ?? '';
        $this->imageAlt = get_post_meta($this->imageId, '_wp_attachment_image_alt', true);
        $this->maxHeight = $this->block['data']['max_height'] ?? '';
        $this->maxWidth = $this->block['data']['max_width'] ?? '';
        $this->imageStyle = $this->block['data']['image_style'] ?? 'cover';

        $this->overlayEnabled = $this->block['data']['overlay_image'] ?? false;
        $this->overlayColor = $this->block['data']['overlay_color'] ?? '';
        $this->overlayOpacity = $this->block['data']['overlay_opacity'] ?? '';

        $this->imageParallax = $this->block['data']['image_parallax'] ?? false;
        $this->parallaxStrength = $this->block['data']['parallax_strength'] ?? 'normal';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blocks.image.index');
    }
}
