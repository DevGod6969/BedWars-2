<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Field extends EmbedElement
{

    /**
     * @param string $name
     * @param string $value
     * @param bool $inline
     */
    public function __construct(string $name, string $value, bool $inline = false)
    {
        $this->setName($name);
        $this->setValue($value);
        $this->setInline($inline);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->information['name'];
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->information['name'] = $name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->information['value'];
    }

    /**
     * @return bool
     */
    public function isInline(): bool
    {
        return $this->information['inline'];
    }

    /**
     * @param bool $inline
     */
    public function setInline(bool $inline): void
    {
        $this->information['inline'] = $inline;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->information['value'] = $value;
    }

    public function jsonSerialize()
    {
        return $this->information;
    }
}