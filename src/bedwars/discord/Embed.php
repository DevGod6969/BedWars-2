<?php

namespace bedwars\discord;

use bedwars\discord\elements\EmbedElement;

class Embed
{

    /** @var array */
    public array $data = [];

    /**
     * @param EmbedElement $element
     * @return void
     */
    public function addElement(EmbedElement $element): void
    {
        foreach ($element->jsonSerialize() as $element => $data) {
            $this->data[$element] = $data;
        }
    }

    /**
     * @param EmbedElement $element
     * @return void
     */
    public function addField(EmbedElement $element): void
    {
        $this->data['fields'][] = $element->jsonSerialize();
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}