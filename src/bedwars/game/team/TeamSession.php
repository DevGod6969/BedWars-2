<?php

namespace bedwars\game\team;

use bedwars\network\player\NetworkPlayer;
use pocketmine\player\Player;

final class TeamSession
{

    /** @var NetworkPlayer[] */
    public array $players = [];
    /** @var string */
    public string $color;
    /** @var int */
    public int $id;

    /**
     * @param string $color
     * @param int $id
     */
    public function __construct(string $color, int $id)
    {
        $this->color = $color;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function addPlayer(Player $player): void
    {
        $this->players[$player->getXuid()] = $player;
    }

    /**
     * @param Player $player
     * @return void
     */
    public function removePlayer(Player $player): void
    {
        unset($this->players[$player->getXuid()]);
    }
}