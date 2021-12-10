<?php

namespace bedwars\network\player;

use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\api\xp\XP;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\data\PlayerData;
use pocketmine\player\Player;

class NetworkPlayer extends Player
{

    /** @var string */
    public string $currentScoreboard = ScoreboardIdentifier::SCOREBOARD_LOBBY;

    /**
     * @param string $scoreboardId
     * @param array $params
     * @return void
     */
    public function setScoreboard(string $scoreboardId, array $params = []): void
    {
        if ($scoreboardId != $this->currentScoreboard) {
            $this->currentScoreboard = $scoreboardId;
            ExtensionManager::getModule(ModulesIdentifier::SCOREBOARD_MANAGER)->get($this)->clearScoreboard();
        }
        $lines = ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getArrayTranslation(['scoreboard', $scoreboardId]);

        foreach ($lines as $id => $line) {
            ExtensionManager::getModule(ModulesIdentifier::SCOREBOARD_MANAGER)->get($this)->addLine(' ' . ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->colorize(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->replaceVars($line, $params)), $id);
        }
    }
}