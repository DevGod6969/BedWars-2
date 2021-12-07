<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Timestamp extends EmbedElement
{

    /** @var string */
    public string $timestamp;

    /**
     * @param string $timestamp
     */
    public function __construct(string $timestamp)
    {
        $this->setTimestamp($timestamp);
    }

    /**
     * @return string
     */
    public function getTimestamp(): string
    {
        return $this->timestamp;
    }

    /**
     * @param string $timestamp
     * @return void
     */
    public function setTimestamp(string $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function jsonSerialize()
    {
        return [
            'timestamp' => $this->getTimestamp()
        ];
    }
}