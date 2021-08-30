<?php

namespace Koralop\bedwars\kit\types;

use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\kit\Kit;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;

/**
 * Class CreateKit
 * @package Koralop\bedwars\kit\types
 */
class CreateKit extends Kit
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Create';
    }

    /**
     * @param BedWarsPlayer $player
     * @return array
     */
    public function getArmor(BedWarsPlayer $player): array
    {
        return [];
    }

    /**
     * @param BedWarsPlayer $player
     * @return array
     */
    public function getItems(BedWarsPlayer $player): array
    {
        return [
            0 => Item::get(ItemIds::WOOL, 14, 1),
            1 => Item::get(ItemIds::WOOL, 11, 1),
            2 => Item::get(ItemIds::WOOL, 4, 1),
            3 => Item::get(ItemIds::WOOL, 5, 1),
            5 => Item::get(ItemIds::IRON_BLOCK, 0, 1),
            6 => Item::get(ItemIds::GOLD_BLOCK, 0, 1),
            7 => Item::get(ItemIds::DIAMOND_BLOCK, 0, 1),
            8 => Item::get(ItemIds::EMERALD_BLOCK, 0, 1),
        ];
    }
}