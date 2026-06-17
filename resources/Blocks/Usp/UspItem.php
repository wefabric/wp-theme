<?php

namespace Theme\Blocks\Usp;

class UspItem
{
    public readonly ?array $iconData;

    public function __construct(
        public readonly string $title,
        public readonly string $text,
        public readonly ?array $link,
        public readonly string $image,
        public readonly ?string $rawIcon,
    ) {
        $this->iconData = $rawIcon ? json_decode($rawIcon, true) : null;
    }
}
