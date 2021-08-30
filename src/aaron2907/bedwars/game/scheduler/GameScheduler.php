<?php

namespace aaron2907\bedwars\game\scheduler;

use aaron2907\bedwars\BedWarsLoader;
use pocketmine\scheduler\Task;

/**
 * Class GameScheduler
 * @package aaron2907\bedwars\game\scheduler
 */
class GameScheduler extends Task
{

    /**
     * @param int $currentTick
     */
    public function onRun(int $currentTick)
    {
        foreach (BedWarsLoader::getInstance()->getGameManager()->getGames() as $game) {
            if (count($game->getPlayers()) != 0)
                $game->tick();
        }
    }
}