<?php

namespace Koralop\bedwars\kit\types;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\kit\Kit;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

/**
 * Class QueueKit
 * @package Koralop\bedwars\kit\types
 */
class QueueKit extends Kit
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Queue';
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
        $leave = Item::get(ItemIds::BED, 0, 1);
        $leave->setCustomName(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.leave', $player->getSession()->getLang())));
        return [
            8 => $leave
        ];
    }
}