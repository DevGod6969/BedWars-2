<?php

namespace bedwars\manager;

use bedwars\api\scoreboard\Scoreboard;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class ScoreboardManager extends Manager
{

    /** @var Scoreboard[] */
    public array $scoreboard = [];

    /**
     * @param Player $player
     * @param string $title
     * @return Scoreboard
     */
    public function add(Player $player, string $title): Scoreboard
    {
        return $this->scoreboard[$player->getName()] = new Scoreboard($player, $title);
    }

    /**
     * @param Player $player
     */
    public function remove(Player $player): void
    {
        unset($this->scoreboard[$player->getName()]);
    }

    /**
     * @param Player $player
     * @return bool
     */
    public function exist(Player $player): bool
    {
        return isset($this->scoreboard[$player->getName()]);
    }

    /**
     * @param Player $player
     * @return Scoreboard
     */
    public function get(Player $player): Scoreboard
    {
        return $this->scoreboard[$player->getName()];
    }
}