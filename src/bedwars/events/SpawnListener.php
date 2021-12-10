<?php

namespace bedwars\events;

use bedwars\Loader;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\data\PlayerData;
use bedwars\network\player\NetworkPlayer;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\world\Position;

class SpawnListener implements Listener
{

    /**
     * @param BlockPlaceEvent $event
     * @return void
     */
    public function handleBlockPlace(BlockPlaceEvent $event): void
    {
        # Variables
        $player = $event->getPlayer();

        # Conditions
        if (!$player instanceof NetworkPlayer)
            return;

        if (!PlayerData::getData($player->getName())->get('god')) {
            if ($this->isSpawn($player->getPosition()))
                $event->call();
        }
    }

    /**
     * @param BlockBreakEvent $event
     * @return void
     */
    public function handleBlockBreak(BlockBreakEvent $event): void
    {
        # Variables
        $player = $event->getPlayer();

        # Conditions
        if (!$player instanceof NetworkPlayer)
            return;

        if (!PlayerData::getData($player->getName())->get('god')) {
            if ($this->isSpawn($player->getPosition()))
                $event->call();
        }
    }

    /**
     * @param EntityDamageEvent $event
     * @return void
     */
    public function handleEntityDamage(EntityDamageEvent $event): void
    {
        # Variables
        $player = $event->getEntity();

        # Conditions
        if (!$player instanceof NetworkPlayer)
            return;

        if ($this->isSpawn($player->getPosition()))
            $event->cancel();

    }

    public function handlePlayerDropItem(PlayerDropItemEvent $event): void{
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($item->getNamedTag()->getString('custom_item') != null)
            $event->call();
    }

    /**
     * @param Position $position
     * @return bool
     */
    public function isSpawn(Position $position): bool
    {
        return $position->getWorld()->getDisplayName() == ExtensionManager::getModule(ModulesIdentifier::CONFIG_MANAGER)->getDefault()->get('default-world');
    }
}