<?php

namespace Koralop\bedwars\kit;

use Koralop\bedwars\BedWarsPlayer;
use pocketmine\item\Item;

/**
 * Class Kit
 * @package Koralop\bedwars\kit
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