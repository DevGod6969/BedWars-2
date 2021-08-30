<?php

namespace aaron2907\bedwars;

use aaron2907\bedwars\game\GameManager;
use aaron2907\bedwars\utils\BedWarsUtils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\utils\TextFormat;

/**
 * Class BedWarsListener
 * @package aaron2907\bedwars
 */
class BedWarsListener implements Listener
{

    /**
     * @param PlayerCreationEvent $event
     */
    public function PlayerCreationEvent(PlayerCreationEvent $event): void
    {
        $event->setPlayerClass(BedWarsPlayer::class);
    }

    /**
     * @param PlayerJoinEvent $event
     */
    public function PlayerJoinEvent(PlayerJoinEvent $event): void
    {
        $player = $event->getPlayer();

        if ($player instanceof BedWarsPlayer)
            $player->join();

        $event->setJoinMessage(TextFormat::colorize(str_replace('{player}', $player->getName(), BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('join.server', $player->getSession()->getLang()))));
    }

    /**
     * @param PlayerInteractEvent $event
     */
    public function PlayerInteractEvent(PlayerInteractEvent $event): void
    {
        $player = $event->getPlayer();
        $item = $event->getItem();

        if (!$player instanceof BedWarsPlayer)
            return;

        switch ($item->getCustomName()) {
            case TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.game', $player->getSession()->getLang())):
                foreach (BedWarsLoader::getInstance()->getGameManager()->getGames() as $game) {
                    if ($game->getStatus() != GameManager::STATUS['playing']) {
                        if ($game->getStatus() != GameManager::STATUS['ending'])
                            $game->addPlayer($player);
                    }
                }
                break;
            case TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.leave', $player->getSession()->getLang())):
                $game = $player->getSession()->getGame();

                if ($game == null)
                    return;

                $game->removePlayer($player);
                $player->spawn();
                break;
            case TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('item.settings', $player->getSession()->getLang())):
                BedWarsUtils::sendOptionForm($player);
                break;
        }
    }
}