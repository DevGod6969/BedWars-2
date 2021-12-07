<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Title extends EmbedElement
{

    /** @var string */
    public string $title;

    /**
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->setTitle($title);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function jsonSerialize()
    {
        return [
            'title' => $this->getTitle()
        ];
    }
}