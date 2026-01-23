<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;
use Theme\Concerns\HasAnimations;
use Theme\Views\ButtonCollection;

class TitleComponent extends Component
{
    use HasAnimations;

    public string $title = '';
    public string $titleColor = '';
    public string $subTitle = '';
    public string $subTitleColor = '';
    public array $subtitleIcon = [];
    public string $subtitleIconColor = '';

    public function __construct(
        public array $block = []
    )
    {
        $this->title = $this->block['data']['title'] ?? '';

        // Load global options for default colors
        $options = function_exists('get_fields') ? \get_fields('option') : [];
        $globalTitleColor = is_string($options['global_title_color'] ?? null) ? $options['global_title_color'] : '';
        $globalSubTitleColor = is_string($options['global_subtitle_color'] ?? null) ? $options['global_subtitle_color'] : '';
        $globalSubtitleIconColor = is_string($options['global_subtitle_icon_color'] ?? null) ? $options['global_subtitle_icon_color'] : '';
        $globalTextColor = is_string($options['global_text_color'] ?? null) ? $options['global_text_color'] : '';

        // Prefer block-specific colors; fallback to their respective globals; treat 0/'0' as unset (Standaard)
        $blockTitleColor = $this->block['data']['title_color'] ?? null;
        $hasBlockTitleColor = (is_string($blockTitleColor) && $blockTitleColor !== '' && $blockTitleColor !== '0') || (is_int($blockTitleColor) && $blockTitleColor !== 0);
        $this->titleColor = $hasBlockTitleColor ? (string) $blockTitleColor : ($globalTitleColor !== '' ? $globalTitleColor : $globalTextColor);

        $this->subTitle = $this->block['data']['subtitle'] ?? '';
        $blockSubTitleColor = $this->block['data']['subtitle_color'] ?? null;
        $hasBlockSubTitleColor = (is_string($blockSubTitleColor) && $blockSubTitleColor !== '' && $blockSubTitleColor !== '0') || (is_int($blockSubTitleColor) && $blockSubTitleColor !== 0);
        $this->subTitleColor = $hasBlockSubTitleColor ? (string) $blockSubTitleColor : ($globalSubTitleColor !== '' ? $globalSubTitleColor : $globalTextColor);

        $icon = $this->block['data']['subtitle_icon'] ?? null;
        if (is_string($icon)) {
            $decoded = json_decode($icon, true);
            $this->subtitleIcon = is_array($decoded) ? $decoded : [];
        } elseif (is_array($icon)) {
            $this->subtitleIcon = $icon;
        } else {
            $this->subtitleIcon = [];
        }

        // Prefer block-specific subtitle icon color; fallback to global subtitle icon color; treat 0/'0' as unset (Standaard)
        $blockSubtitleIconColor = $this->block['data']['subtitle_icon_color'] ?? null;
        $hasBlockSubtitleIconColor = (is_string($blockSubtitleIconColor) && $blockSubtitleIconColor !== '' && $blockSubtitleIconColor !== '0') || (is_int($blockSubtitleIconColor) && $blockSubtitleIconColor !== 0);
        $this->subtitleIconColor = $hasBlockSubtitleIconColor
            ? (string) $blockSubtitleIconColor
            : ($globalSubtitleIconColor !== '' ? $globalSubtitleIconColor : ($globalSubTitleColor !== '' ? $globalSubTitleColor : $globalTextColor));

        $this->setAnimations();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.title.index');
    }
}
