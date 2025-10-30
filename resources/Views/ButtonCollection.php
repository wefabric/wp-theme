<?php

namespace Theme\Views;

use Illuminate\Support\Collection;
use Theme\Views\Components\Button;

class ButtonCollection extends Collection
{

    public int $amount = 2;

    public static function fromBlockData(array $block, int $amount = 2): self
    {
        $collection = new self();

        for($i = 1; $i <= $amount; $i++)
        {
            $collection->put($i, new Button(
                $block['data']['button_button_'.$i]['title'] ?? '',
                 $block['data']['button_button_'.$i]['url'] ?? '',
                $block['data']['button_button_'.$i]['target'] ?? '_self',
                $block['data']['button_button_'.$i.'_color'] ?? '',
                $block['data']['button_button_'.$i.'_style'] ?? '',
                $block['data']['button_button_'.$i.'_download'] ?? false,
                $block['data']['button_button_'.$i.'_icon'] ?? '',
            ));
        }

        return $collection;
    }

}