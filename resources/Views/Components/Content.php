<?php

namespace Theme\Views\Components;

use Illuminate\View\Component;

class Content extends Component
{

    public function __construct(
        public string $content = '',
        public string $class = ''
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.content', [
            'content' =>  apply_filters('the_content', $this->content),
            'class' => $this->class,
        ]);
    }
}
