<?php

namespace aaron2907\bedwars\game;

use aaron2907\bedwars\BedWarsLoader;
use aaron2907\bedwars\BedWarsPlayer;
use aaron2907\bedwars\entity\types\ShopEntity;
use aaron2907\bedwars\shop\ItemShop;
use aaron2907\bedwars\shop\UpgradeShop;
use aaron2907\bedwars\utils\BedWarsUtils;
use pocketmine\block\BlockIds;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\item\Bed;
use pocketmine\utils\TextFormat;

/**
 * Class GameListener
 * @package aaron2907\bedwars\game
 */
class GameListener implements Listener
{

    /**
     * @param BlockPlaceEvent $event
     */
    public function BlockPlaceEvent(BlockPlaceEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if (!$player instanceof BedWarsPlayer)
            return;

        if ($player->getSession()->isPlaceBed()) {
            switch ($block->getId()) {
                case BlockIds::IRON_BLOCK:
                    $player->getSession()->createArena['generators'][] = ['pos' => $block, 'type' => 'iron'];
                    break;
                case BlockIds::GOLD_BLOCK:
                    $player->getSession()->createArena['generators'][] = ['pos' => $block, 'type' => 'gold'];
                    break;
                case BlockIds::EMERALD_BLOCK:
                    $player->getSession()->createArena['generators'][] = ['pos' => $block, 'type' => 'emerald'];
                    break;
                case BlockIds::DIAMOND_BLOCK:
                    $player->getSession()->createArena['generators'][] = ['pos' => $block, 'type' => 'diamond'];
                    break;
            }

            switch ($block->getDamage()) {
                case 4:
                    // Yellow Wool
                    $player->getSession()->createArena['bed']['yellow'] = $block;
                    $player->sendMessage(TextFormat::colorize(str_replace('{color}', 'Yellow', BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('bed.place', $player->getSession()->getLang()))));

                    if (count($player->getSession()->createArena['bed']) == 4)
                        BedWarsUtils::sendBedWarsCreate($player);

                    break;
                case 11:
                    $player->getSession()->createArena['bed']['blue'] = $block;
                    $player->sendMessage(TextFormat::colorize(str_replace('{color}', 'Blue', BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('bed.place', $player->getSession()->getLang()))));

                    if (count($player->getSession()->createArena['bed']) == 4)
                        BedWarsUtils::sendBedWarsCreate($player);

                    break;
                case 14:
                    $player->getSession()->createArena['bed']['red'] = $block;
                    $player->sendMessage(TextFormat::colorize(str_replace('{color}', 'Red', BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('bed.place', $player->getSession()->getLang()))));

                    if (count($player->getSession()->createArena['bed']) == 4)
                        BedWarsUtils::sendBedWarsCreate($player);

                    break;
                case 5:
                    $player->getSession()->createArena['bed']['green'] = $block;
                    $player->sendMessage(TextFormat::colorize(str_replace('{color}', 'Green', BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('bed.place', $player->getSession()->getLang()))));

                    if (count($player->getSession()->createArena['bed']) == 4)
                        BedWarsUtils::sendBedWarsCreate($player);

                    break;
            }
            $event->setCancelled(true);
        }
    }

    /**
     * @param EntityDamageByEntityEvent $event
     */
    public function EntityDamageByEntityEvent(EntityDamageByEntityEvent $event): void
    {
        $damager = $event->getDamager();
        $entity = $event->getEntity();

        if ($entity instanceof ShopEntity) {

            if (!$damager instanceof BedWarsPlayer)
                return;

            if (!$damager->getSession()->inTeam())
                return;

            if ($entity->getType() == 'item')
                ItemShop::sendDefaultShop($damager);
            else
                UpgradeShop::sendDefaultShop($damager);
            return;
        }

        if (!$damager instanceof BedWarsPlayer || !$entity instanceof BedWarsPlayer)
            return;

        $game = $damager->getSession()->getGame();

        if ($game == null)
            return;

        if ($event->getFinalDamage() <= 0)
            $game->playerDeath($damager, $entity);

    }

    /**
     * @param BlockBreakEvent $event
     */
    public function BlockBreakEvent(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();

        if (!$player instanceof BedWarsPlayer)
            return;

        /** @var Game|null $game */
        $game = $player->getSession()->getGame();

        if ($game != null) {
            if ($block instanceof Bed) {

                $team = $game->getTeamByBedPosition($block);

                if ($team != null) {
                    $team->updateBedState(false);

                    foreach ($team->getPlayers() as $player)
                        $player->sendTitle(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('bed.destroyed', $player->getSession()->getLang())));

                }
            }
        }
    }
}