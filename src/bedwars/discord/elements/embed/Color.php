<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Color extends EmbedElement
{

    const BLUE = "1f5fa0";
    const SEA_GREEN = "35b27f";
    const RED = "ff5252";
    const FOREST_GREEN = "255836";
    const GREEN = "35b27f";
    const ORANGE = "ff8633";
    const YELLOW = "FFF933";
    const GOLD = 'FCD309';
    const DARK_RED = 'BB0000';

    /** @var string */
    public string $color;

    /**
     * @param string $color
     */
    public function __construct(string $color)
    {
        if (strtolower($color) == 'random')
            $color = floor(rand() * (0xffffff + 1));

        $this->setColor($color);
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    public function jsonSerialize()
    {
        return [
            'color' => $this->getColor()
        ];
    }
}