<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;

class FormBlock extends BlockComponent
{
    use HasTextContent;

    public $form = null;
    public string $formTitle = '';
    public string $formTitleColor = '';
    public string $formSubTitle = '';
    public string $formSubTitleColor = '';
    public string $formTextColor = '';
    public string $formInputColor = '';
    public string $formBackgroundColor = '';

    public function setBlockData(): void
    {
        $this->setTextContentData();

        // Form details
        $this->form = $this->block['data']['form'] ?? null;
        $this->formTitle = $this->block['data']['form_title'] ?? '';
        $this->formSubTitle = $this->block['data']['form_subtitle'] ?? '';

        // Colors
        $this->formTitleColor = $this->getBlockColor('form_title_color', '');
        $this->formSubTitleColor = $this->getBlockColor('form_subtitle_color', '');
        $this->formTextColor = $this->getBlockColor('form_text_color', '');
        $this->formInputColor = $this->getBlockColor('form_input_color', '');
        $this->formBackgroundColor = $this->getBlockColor('form_background_color', '');
    }

    protected function getBlockColor(string $key, string $default): string
    {
        $color = $this->block['data'][$key] ?? null;
        $hasColor = (is_string($color) && $color !== '' && $color !== '0')
            || (is_int($color) && $color !== 0);

        return $hasColor ? (string)$color : $default;
    }

    public function render()
    {
        return view('components.blocks.form.index');
    }
}
