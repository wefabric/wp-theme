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
        $this->textColor = $this->block['data']['text_color'] ?? '';

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
