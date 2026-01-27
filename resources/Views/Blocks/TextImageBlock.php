<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;

class TextImageBlock extends BlockComponent
{
    use HasTextContent;

    public function setBlockData(): void
    {
        $this->setTextContentData();

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
