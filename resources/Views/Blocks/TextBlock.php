<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;

class TextBlock extends BlockComponent
{
    use HasTextContent;

    public function setBlockData(): void
    {
        $this->setTextContentData();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blocks.text.index');
    }
}
