<?php

namespace aaron2907\bedwars\kit;

use aaron2907\bedwars\BedWarsPlayer;
use pocketmine\item\Item;

/**
 * Class Kit
 * @package aaron2907\bedwars\kit
 */
abstract class Kit
{

    /**
     * @return string
     */
    abstract function getName(): string;

    /**
     * @param BedWarsPlayer $player
     * @return array
     */
    abstract function getItems(BedWarsPlayer $player): array;

    /**
     * @param BedWarsPlayer $player
     * @return array
     */
    abstract function getArmor(BedWarsPlayer $player): array;
}