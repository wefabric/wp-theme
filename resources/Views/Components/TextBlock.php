<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;
use Theme\Views\ButtonCollection;

class TextBlock extends Component
{

    public string $titleColor = '';
    public string $subTitle = '';
    public string $subTitleColor = '';
    public string $subtitleIcon = '';
    public string $subtitleIconColor = '';
    public string $text = '';
    public string $textColor = '';

    public ?ButtonCollection $buttons = null;

    public string $textPosition = '';
    public array $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
    public string $textClass = '';

    public string $titleAnimation = '';
    public string $flyInAnimation = '';
    public string $textFadeDirection = 'bottom';
    public function __construct(
        public array $block = []
    )
    {
        $this->titleColor = $block['data']['title_color'] ?? '';
        $this->subTitle = $block['data']['subtitle'] ?? '';
        $this->subTitleColor = $block['data']['subtitle_color'] ?? '';
        $this->subtitleIcon = $block['data']['subtitle_icon'] ?? '';
        $this->subtitleIcon = $this->subtitleIcon ? json_decode($this->subtitleIcon, true) : '';
        $this->subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
        $this->text = $block['data']['text'] ?? '';
        $this->textColor = $block['data']['text_color'] ?? '';

        $this->buttons = ButtonCollection::fromBlockData($this->block);


        $this->textPosition = $block['data']['text_position'] ?? '';
        $this->textClass = $this->textClassMap[$this->textPosition] ?? '';

        // Animaties
        $this->titleAnimation = $block['data']['title_animation'] ?? false;
        $this->flyInAnimation = $block['data']['flyin_animation'] ?? false;
        $this->textFadeDirection = $block['data']['flyin_direction'] ?? 'bottom';

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
