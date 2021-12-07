<?php

namespace bedwars\discord\elements\basic;

use bedwars\discord\elements\BasicElement;

class Avatar extends BasicElement
{

    /** @var string */
    public string $avatarUrl;

    public function __construct(string $avatarUrl)
    {
        $this->setAvatarURL($avatarUrl);
    }

    /**
     * @return string
     */
    public function getAvatarURL(): string
    {
        return $this->avatarUrl;
    }

    /**
     * @param string $avatarURL
     */
    public function setAvatarURL(string $avatarURL): void
    {
        $this->avatarUrl = $avatarURL;
    }

    public function jsonSerialize()
    {
        return [
            'avatar_url' => $this->getAvatarURL()
        ];
    }
}