<?php

namespace bedwars\network\player;

use bedwars\api\xp\XP;
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
                    '%level%' => XP::checkLevel($this->getName()),
                    '%gadgetsmenu_mystery_boxes%' => PlayerData::getData($this->getName())->get('gadgetsmenu_mystery_boxes'),
                    '%money%' => PlayerData::getData($this->getName())->get('money'),
                    '%kills%' => PlayerData::getData($this->getName())->get('kills'),
                    '%wins%' => PlayerData::getData($this->getName())->get('wins'),
                    '%currentXp%' => XP::get($this->getName()),
                    '%requiredXp%' => XP::getXpRequiredForLevel(XP::checkLevel($this->getName())),
                    '%server_ip%' => ExtensionManager::CONFIG()->getDefault()->get('server')['ip'],
                    '%progress%' => XP::getBarXP($this->getName())
                ])), $id);
        }
    }
}