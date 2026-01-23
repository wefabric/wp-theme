<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;

class Button extends Component
{

    public function __construct(
        public string $text = '',
        public string $link = '',
        public string $target = '_self',
        public string $color = '',
        public string $style = '',
        public bool $download = false,
        public string $icon = '',
    )
    {
        if (!empty($button1Icon)) {
            $iconData = json_decode($button1Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $this->icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        // Ensure a valid color slug; fall back to 'primary-color' if empty or '0'
        $colorSlug = trim($this->color);
        if ($colorSlug === '' || $colorSlug === '0') {
            $colorSlug = 'primary-color';
        }
        // Defensive: strip any accidental prefixes
        if (strpos($colorSlug, 'bg-') === 0) $colorSlug = substr($colorSlug, 3);
        if (strpos($colorSlug, 'text-') === 0) $colorSlug = substr($colorSlug, 5);

        return view('components.buttons.default', [
            'text' => $this->text,
            'href' => $this->link,
            'alt' => $this->text,
            'colors' => 'btn-' . $colorSlug . ' btn-' . $this->style,
            'class' => 'rounded-lg',
            'target' => $this->target,
            'icon' => $this->icon,
            'download' => $this->download,
        ]);
    }
}
