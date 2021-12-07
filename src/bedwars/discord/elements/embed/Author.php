<?php

namespace bedwars\discord\elements\embed;

use bedwars\discord\elements\EmbedElement;

class Author extends EmbedElement
{

    /**
     * @param string $name
     * @param string|null $url
     * @param string|null $iconURL
     */
    public function __construct(string $name, string $url = null, string $iconURL = null)
    {
        $this->setName($name);
        $this->setUrl($url);
        $this->setIconURL($iconURL);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->information['name'] = $name;
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
    public function getName(): string
    {
        return $this->information['name'];
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->information['url'];
    }

    /**
     * @param string|null $iconURL
     */
    public function setIconURL(?string $iconURL): void
    {
        $this->information['icon_url'] = $iconURL;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->information['url'] = $url;
    }

    public function jsonSerialize()
    {
        return [
            'author' => $this->information
        ];
    }
}