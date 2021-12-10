<?php

namespace bedwars\events;

use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\data\PlayerData;
use bedwars\network\NetworkSession;
use bedwars\network\player\NetworkPlayer;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCreationEvent;
use pocketmine\event\player\PlayerJoinEvent;

class PlayerListener implements Listener
{

    /**
     * @param PlayerCreationEvent $event
     * @return void
     */
    public function handlePlayerCreation(PlayerCreationEvent $event): void
    {
        $event->setPlayerClass(NetworkPlayer::class);
    }

    /**
     * @param PlayerJoinEvent $event
     * @return void
     */
    public function handlePlayerJoin(PlayerJoinEvent $event): void
    {
        # Variables
        $player = $event->getPlayer();

        # Condition
        if (!$player instanceof NetworkPlayer)
            return;

        # Init player
        NetworkSession::initPlayer($player);

        # Message
        $event->setJoinMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('player-join', ['%playerName%' => $player->getName()]));
    }
}