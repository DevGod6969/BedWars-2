<?php

namespace bedwars\discord\elements\basic;

use bedwars\discord\elements\BasicElement;

class Content extends BasicElement
{

    /** @var string */
    public string $text;

    /**
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->setText($text);
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }

    public function jsonSerialize()
    {
        return [
            'content' => $this->getText()
        ];
    }
}