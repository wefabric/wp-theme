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
    public string $subtitleIcon = '';
    public string $subtitleIconColor = '';

    public function __construct(
        public array $block = []
    )
    {
        $this->title = $this->block['data']['title'] ?? '';
        $this->titleColor = $block['data']['title_color'] ?? '';
        $this->subTitle = $block['data']['subtitle'] ?? '';
        $this->subTitleColor = $block['data']['subtitle_color'] ?? '';
        $this->subtitleIcon = $block['data']['subtitle_icon'] ?? '';
        $this->subtitleIcon = $this->subtitleIcon ? json_decode($this->subtitleIcon, true) : '';
        $this->subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';

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
