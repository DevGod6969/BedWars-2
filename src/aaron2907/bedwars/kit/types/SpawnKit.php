<?php

namespace aaron2907\bedwars\kit\types;

use aaron2907\bedwars\BedWarsLoader;
use aaron2907\bedwars\BedWarsPlayer;
use aaron2907\bedwars\kit\Kit;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\utils\TextFormat;

/**
 * Class SpawnKit
 * @package aaron2907\bedwars\kit\types
 */
class SpawnKit extends Kit
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Spawn';
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
        $spawn = Item::get(ItemIds::NETHER_STAR, 0, 1);
        $spawn->setCustomName(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.settings', $player->getSession()->getLang())));

        $game = Item::get(ItemIds::COMPASS, 0, 1);
        $game->setCustomName(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.game', $player->getSession()->getLang())));

        return [
            8 => $spawn,
            0 => $game
        ];
    }
}