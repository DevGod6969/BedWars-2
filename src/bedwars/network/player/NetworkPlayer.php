<?php

namespace bedwars\network\player;

use bedwars\manager\ExtensionManager;
use bedwars\network\data\PlayerData;
use pocketmine\player\Player;

class NetworkPlayer extends Player
{

    /**
     * @param string $scoreboardId
     * @return void
     */
    public function setScoreboard(string $scoreboardId): void
    {
        $lines = ExtensionManager::TRANSLATION()->getArrayTranslation(['scoreboard', $scoreboardId]);

        foreach ($lines as $id => $line) {
            ExtensionManager::SCOREBOARD()->get($this)->addLine(' ' . ExtensionManager::TRANSLATION()->colorize(ExtensionManager::TRANSLATION()->replaceVars($line, [
                    '%online_players%' => count($this->getServer()->getOnlinePlayers()),
                    '%level%' => PlayerData::getData($this->getName())->get('level'),
                    '%loot_chest%' => PlayerData::getData($this->getName())->get('loot_chest'),
                    '%coins%' => PlayerData::getData($this->getName())->get('coins'),
                    '%kills%' => PlayerData::getData($this->getName())->get('kills'),
                    '%wins%' => PlayerData::getData($this->getName())->get('wins'),
                ])), $id);
        }
    }
}