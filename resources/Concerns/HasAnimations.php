<?php

namespace Theme\Concerns;

trait HasAnimations
{
    public bool $titleAnimation = false;
    public bool $flyInAnimation = false;
    public string $textFadeDirection = 'bottom';

    protected function normalizeBool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }
        if (is_int($value)) {
            return $value === 1;
        }
        if (is_string($value)) {
            $v = strtolower(trim($value));
            return in_array($v, ['1', 'true', 'yes', 'on'], true);
        }
        return false;
    }

    public function setAnimations(): void
    {
        $this->titleAnimation = $this->normalizeBool($this->block['data']['title_animation'] ?? false);
        $this->flyInAnimation = $this->normalizeBool($this->block['data']['flyin_animation'] ?? false);

        $dir = $this->block['data']['flyin_direction'] ?? 'bottom';
        $dir = is_string($dir) ? strtolower($dir) : 'bottom';
        $allowed = ['left', 'right', 'top', 'bottom'];
        $this->textFadeDirection = in_array($dir, $allowed, true) ? $dir : 'bottom';
    }

}