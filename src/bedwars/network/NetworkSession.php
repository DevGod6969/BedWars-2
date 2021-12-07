<?php

namespace bedwars\network;


use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\api\xp\XP;
use bedwars\manager\ExtensionManager;
use bedwars\network\data\PlayerData;
use bedwars\network\player\NetworkPlayer;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;

final class NetworkSession
{

    public static function startSession(): void
    {
    }

    /**
     * @param NetworkPlayer $player
     * @return void
     */
    public static function initPlayer(NetworkPlayer $player): void
    {
        # Player Data
        PlayerData::initializeData($player->getName());
        XP::set($player->getName(), 6);

        # Scoreboard
        ExtensionManager::SCOREBOARD()->add($player, ExtensionManager::TRANSLATION()->getMessageTranslate(['scoreboard', 'title']));
        $player->setScoreboard(ScoreboardIdentifier::SCOREBOARD_LOBBY);

        # Items
        $compass = ItemFactory::getInstance()->get(ItemIds::COMPASS, 0);
        $compass->setCustomName(ExtensionManager::TRANSLATION()->getMessageTranslate('lobby-items-compass-name'));
        $compass->setLore(ExtensionManager::TRANSLATION()->getArrayTranslation('lobby-items-compass-lore'));
        $player->getInventory()->setItem(0, $compass);
        $skull = ItemFactory::getInstance()->get(ItemIds::SKULL, 0);
        $skull->setCustomName(ExtensionManager::TRANSLATION()->getMessageTranslate('lobby-items-skull-name'));
        $player->getInventory()->setItem(1, $skull);
        $star = ItemFactory::getInstance()->get(ItemIds::NETHER_STAR, 0);
        $star->setCustomName(ExtensionManager::TRANSLATION()->getMessageTranslate('lobby-items-selector-name'));
        $star->setLore(ExtensionManager::TRANSLATION()->getArrayTranslation('lobby-items-selector-lore'));
        $player->getInventory()->setItem(8, $star);
        $chest = ItemFactory::getInstance()->get(ItemIds::CHEST, 0);
        $chest->setCustomName(ExtensionManager::TRANSLATION()->getMessageTranslate('lobby-items-language-name'));
        $chest->setLore(ExtensionManager::TRANSLATION()->getArrayTranslation('lobby-items-language-lore'));
        $player->getInventory()->setItem(4, $chest);
    }
}