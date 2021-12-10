<?php

namespace bedwars\kit;

use bedwars\network\player\NetworkPlayer;

abstract class Kit
{

    /**
     * @param NetworkPlayer $player
     */
    public function __construct(NetworkPlayer $player)
    {
        $player->getInventory()->setContents($this->getItems());
    }

    /**
     * @return array
     */
    public function getArmor(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function getItems(): array
    {
        return [];
    }
}