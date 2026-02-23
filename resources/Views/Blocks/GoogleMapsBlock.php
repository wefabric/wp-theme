<?php

namespace Theme\Views\Blocks;

use Theme\Concerns\HasTextContent;
use Theme\Views\Components\BlockComponent;

class GoogleMapsBlock extends BlockComponent
{
    use HasTextContent;

    public string $mapsCity = '';
    public string $mapsStreet = '';
    public string $mapsHouseNumber = '';

    public function setBlockData(): void
    {
        $this->setTextContentData();

        $this->mapsCity = $this->block['data']['maps_city'] ?? '';
        $this->mapsStreet = $this->block['data']['maps_street'] ?? '';
        $this->mapsHouseNumber = $this->block['data']['maps_house_number'] ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.blocks.google-maps.index');
    }
}
