<?php

namespace Theme\Views\Blocks;

use Theme\Views\ButtonCollection;
use Theme\Views\Components\BlockComponent;

class TextImageBlock extends BlockComponent
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

        // Special rule for this block: when text is positioned on the right side,
        // keep the column order on the right but align text content to the left.
        if ($this->textPosition === 'right') {
            $this->textClass = 'text-left justify-start';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blocks.text-image.index');
    }
}
