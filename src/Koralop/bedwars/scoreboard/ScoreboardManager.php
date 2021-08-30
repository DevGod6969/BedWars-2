<?php

namespace Koralop\bedwars\scoreboard;

use Koralop\bedwars\BedWarsPlayer;

/**
 * Class ScoreboardManager
 * @package Koralop\bedwars\scoreboard
 */
class ScoreboardManager
{

    /** @var Scoreboard[] */
    protected array $scoreboard = [];

    /**
     * @param BedWarsPlayer $player
     */
    public function addScoreboard(BedWarsPlayer $player): void
    {
        $this->scoreboard[$player->getXuid()] = new Scoreboard($player);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function removeScoreboard(BedWarsPlayer $player): void
    {
        unset($this->scoreboard[$player->getXuid()]);
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function isScoreboard(BedWarsPlayer $player): bool
    {
        return isset($this->scoreboard[$player->getXuid()]);
    }

    /**
     * @param BedWarsPlayer $player
     * @return Scoreboard
     */
    public function getScoreboard(BedWarsPlayer $player): Scoreboard
    {
        return $this->scoreboard[$player->getXuid()];
    }
}