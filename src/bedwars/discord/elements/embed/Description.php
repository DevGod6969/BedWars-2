<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Description extends EmbedElement
{

    /** @var string */
    public string $description;

    /**
     * @param string $description
     */
    public function __construct(string $description)
    {
        $this->setDescription($description);
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function jsonSerialize()
    {
        return [
            'description' => $this->getDescription()
        ];
    }
}