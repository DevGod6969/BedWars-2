<?php

namespace bedwars\events;

use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\manager\ExtensionManager;
use bedwars\network\data\PlayerData;
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
        $player = $event->getPlayer();

        if (!$player instanceof NetworkPlayer)
            return;

        PlayerData::initializeData($player->getName());
        ExtensionManager::SCOREBOARD()->add($player, ExtensionManager::TRANSLATION()->getMessageTranslate(['scoreboard', 'title']));
        $player->setScoreboard(ScoreboardIdentifier::SCOREBOARD_LOBBY);

        $event->setJoinMessage(ExtensionManager::TRANSLATION()->getMessageTranslate('player-join', ['%playerName%' => $player->getName()]));
    }
}