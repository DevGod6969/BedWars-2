<?php

namespace Koralop\bedwars\game\scheduler;

use Koralop\bedwars\BedWarsLoader;
use pocketmine\scheduler\Task;

/**
 * Class GameScheduler
 * @package Koralop\bedwars\game\scheduler
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