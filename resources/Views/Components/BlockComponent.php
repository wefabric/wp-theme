<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;
use Theme\Concerns\HasAnimations;

abstract class BlockComponent extends Component
{
    use HasAnimations;

    public int|string $blockWidth = 100;
    public string $blockClass = '';
    public string $fullScreenClass = '';
    public array $blockClassMap = [50 => 'w-full xl:w-1/2', 66 => 'w-full xl:w-2/3', 80 => 'w-full xl:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full', 'full-screen' => 'w-full'];


    public function __construct(
        public array $block = []
    )
    {
        $this->blockWidth = $this->block['data']['block_width'] ?? 100;
        $this->blockClass = $this->blockClassMap[$this->blockWidth] ?? '';

        $isFullscreen = ($this->blockWidth === 'fullscreen' || $this->blockWidth === 'full-screen');
        $this->fullScreenClass = $isFullscreen ? '' : 'container mx-auto';

        $this->setAnimations();
        $this->setBlockData();
    }

    public abstract function setBlockData(): void;

}