<?php

namespace bedwars\discord\elements\basic;

use bedwars\discord\elements\BasicElement;

class Username extends BasicElement
{

    /** @var string */
    public string $username;

    /**
     * @param string $username
     */
    public function __construct(string $username)
    {
        $this->setUsername($username);
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function jsonSerialize()
    {
        return [
            'username' => $this->getUsername()
        ];
    }
}