<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Footer extends EmbedElement
{

    /**
     * @param string $text
     * @param string|null $icon_url
     */
    public function __construct(string $text, string $icon_url = null)
    {
        $this->setText($text);
        if ($icon_url != null)
            $this->setIconURL($icon_url);
    }

    /**
     * @param string $name
     */
    public function setText(string $name): void
    {
        $this->information['text'] = $name;
    }

    /**
     * @return string|null
     */
    public function getIconURL(): ?string
    {
        return $this->information['icon_url'];
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->information['text'];
    }

    /**
     * @param string|null $iconURL
     */
    public function setIconURL(?string $iconURL): void
    {
        $this->information['icon_url'] = $iconURL;
    }

    public function jsonSerialize()
    {
        return [
            'footer' => $this->information
        ];
    }
}