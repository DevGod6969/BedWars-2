<?php

namespace bedwars\discord;

use bedwars\discord\elements\BasicElement;

class Webhook
{

    /** @var string */
    public string $url;
    /** @var array */
    public array $data = [];

    /**
     * @param string $url
     */
    public function __construct(string $url)
    {
        $this->setURL($url);
    }

    /**
     * @return string
     */
    public function getURL(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setURL(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @param BasicElement $element
     * @return void
     */
    public function addElement(BasicElement $element): void
    {
        foreach ($element->jsonSerialize() as $element => $data)
            $this->data[$element] = $data;
    }

    /**
     * @param Embed $embed
     * @return void
     */
    public function addEmbed(Embed $embed): void
    {
        $this->data["embeds"][] = $embed->getData();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}