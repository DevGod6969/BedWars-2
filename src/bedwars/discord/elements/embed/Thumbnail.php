<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Thumbnail extends EmbedElement
{

    /** @var string */
    public string $url;


    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setUrl($url);
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    public function jsonSerialize()
    {
        return [
            'thumbnail' => [
                'url' => $this->getUrl()
            ]
        ];
    }
}