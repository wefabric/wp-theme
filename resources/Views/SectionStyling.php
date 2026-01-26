<?php

namespace Theme\Views;

use Illuminate\Support\Collection;

class SectionStyling
{
    public ?Collection $screenPaddings = null;

    public ?Collection $screenMargins = null;

    /**
     * Build inline CSS for paddings and margins for a specific section instance.
     * Returns a complete <style>...</style> block or an empty string.
     */
    public function toInlineCss(string $blockType, int $randomNumber): string
    {
        $hasPadding = $this->screenPaddings && $this->screenPaddings->where('enabled', true)->first();
        $hasMargin = $this->screenMargins && $this->screenMargins->where('enabled', true)->first();
        if (!$hasPadding && !$hasMargin) {
            return '';
        }

        $css = '';

        if ($hasPadding) {
            $css .= '.' . $blockType . '-' . $randomNumber . '-custom-padding {' . PHP_EOL;
            foreach ($this->screenPaddings as $screenPaddingData) {
                $size = (int)$screenPaddingData->get('size');
                $css .= '    @media only screen and (min-width: ' . $size . 'px) {' . PHP_EOL;
                foreach (['top','right','bottom','left'] as $side) {
                    $val = $screenPaddingData->get($side);
                    if ($val !== null && $val !== '') {
                        $css .= '        padding-' . $side . ': ' . (int)$val . 'px;' . PHP_EOL;
                    }
                }
                $css .= '    }' . PHP_EOL;
            }
            $css .= '}' . PHP_EOL . PHP_EOL;
        }

        if ($hasMargin) {
            $css .= '.' . $blockType . '-' . $randomNumber . '-custom-margin {' . PHP_EOL;
            foreach ($this->screenMargins as $screenMarginData) {
                $size = (int)$screenMarginData->get('size');
                $css .= '    @media only screen and (min-width: ' . $size . 'px) {' . PHP_EOL;
                foreach (['top','right','bottom','left'] as $side) {
                    $val = $screenMarginData->get($side);
                    if ($val !== null && $val !== '') {
                        $css .= '        margin-' . $side . ': ' . (int)$val . 'px;' . PHP_EOL;
                    }
                }
                $css .= '    }' . PHP_EOL;
            }
            $css .= '}' . PHP_EOL;
        }

        return '<style>' . PHP_EOL . $css . '</style>';
    }

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
            foreach (['top','right','bottom','left'] as $side) {
                $val = $padding->get($side);
                if ($val !== null && $val !== '') { $padding->put('enabled', true); break; }
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
            foreach (['top','right','bottom','left'] as $side) {
                $val = $margin->get($side);
                if ($val !== null && $val !== '') { $margin->put('enabled', true); break; }
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