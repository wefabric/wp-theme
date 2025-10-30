<?php

namespace Theme\Concerns;

trait HasAnimations
{
    public string $titleAnimation = '';
    public string $flyInAnimation = '';
    public string $textFadeDirection = 'bottom';

    public function setAnimations(): void
    {
        $this->titleAnimation = $this->block['data']['title_animation'] ?? false;
        $this->flyInAnimation = $this->block['data']['flyin_animation'] ?? false;
        $this->textFadeDirection = $this->block['data']['flyin_direction'] ?? 'bottom';
    }

}