<?php

namespace Theme\Views\Components;

use Theme\Views\ButtonCollection;

class TextBlock extends BlockComponent
{

    public string $text = '';
    public string $textColor = '';

    public ?ButtonCollection $buttons = null;

    public string $textPosition = '';
    public array $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
    public string $textClass = '';

    public function setBlockData(): void
    {
        $this->text = $this->block['data']['text'] ?? '';

        // Load global options for default text color
        $options = function_exists('get_fields') ? \get_fields('option') : [];
        $globalTextColor = is_string($options['global_text_color'] ?? null) ? $options['global_text_color'] : '';

        // Prefer block-specific text color; fallback to global; treat 0/'0' as unset (Standaard)
        $blockTextColor = $this->block['data']['text_color'] ?? null;
        $hasBlockTextColor = (is_string($blockTextColor) && $blockTextColor !== '' && $blockTextColor !== '0') || (is_int($blockTextColor) && $blockTextColor !== 0);
        $this->textColor = $hasBlockTextColor ? (string) $blockTextColor : $globalTextColor;

        $this->buttons = ButtonCollection::fromBlockData($this->block);

        $this->textPosition = $this->block['data']['text_position'] ?? '';
        $this->textClass = $this->textClassMap[$this->textPosition] ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.text-block.index');
    }
}
