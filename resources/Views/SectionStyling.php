<?php

namespace Theme\Views;

use Illuminate\Support\Collection;

class SectionStyling
{
    public ?Collection $screenPaddings = null;

    public ?Collection $screenMargins = null;

    public static array $screenSizes = [
        'mobile' => 0,
        'tablet' => 640,
        'desktop' => 1280,
        'desktop_xl' => 1536,
    ];

    public function __construct(Collection $screenPaddings = null, Collection $screenMargins = null)
    {
        $this->screenPaddings = $screenPaddings;
        $this->screenMargins = $screenMargins;
    }

    public static function fromBlockData(array $block): self
    {
        $screenPaddings = new Collection();

        foreach (self::$screenSizes as $screenSize => $screenSizeValue) {
            $padding = new Collection([
                'size' => $screenSizeValue,
                'top' => $block['data']['padding_'.$screenSize.'_padding_top'] ?? '',
                'right' => $block['data']['padding_'.$screenSize.'_padding_right'] ?? '',
                'bottom' => $block['data']['padding_'.$screenSize.'_padding_bottom'] ?? '',
                'left' => $block['data']['padding_'.$screenSize.'_padding_left'] ?? '',
            ]);

            $padding->put('enabled', false);
            if($padding->get('top') || $padding->get('right') || $padding->get('bottom') || $padding->get('left')) {
                $padding->put('enabled', true);
            }
            $screenPaddings->put($screenSize, $padding);
        }

        $screenMargins = new Collection();
        foreach (self::$screenSizes as $screenSize => $screenSizeValue) {
            $margin = new Collection([
                'size' => $screenSizeValue,
                'top' => $block['data']['margin_'.$screenSize.'_margin_top'] ?? '',
                'right' => $block['data']['margin_'.$screenSize.'_margin_right'] ?? '',
                'bottom' => $block['data']['margin_'.$screenSize.'_margin_bottom'] ?? '',
                'left' => $block['data']['margin_'.$screenSize.'_margin_left'] ?? '',
            ]);

            $margin->put('enabled', false);
            if($margin->get('top') || $margin->get('right') || $margin->get('bottom') || $margin->get('left')) {
                $margin->put('enabled', true);
            }
            $screenMargins->put($screenSize, $margin);
        }

        return new self($screenPaddings, $screenMargins);
    }

    public function isNotEmpty(): bool
    {
        return $this->screenPaddings->where('enabled', true)->first() || $this->screenMargins->where('enabled', true)->first();
    }
}