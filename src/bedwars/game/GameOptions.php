<?php

namespace bedwars\game;

use bedwars\arena\Arena;
use pocketmine\world\Position;

final class GameOptions
{

    /** @var int */
    public int $playersPerTeam = 4;
    /** @var int */
    public int $maxTeams = 8;
    /** @var Arena */
    public Arena $arena;
    /** @var array */
    public array $spawnTeams = [];

    public static function create(): self
    {
        return new self;
    }

    /**
     * @return Arena
     */
    public function getArena(): Arena
    {
        return $this->arena;
    }

    /**
     * @param Arena $arena
     * @return $this
     */
    public function setArena(Arena $arena): self
    {
        $this->arena = $arena;
        return $this;
    }

    /**
     * @return int
     */
    public function getPlayersPerTeam(): int
    {
        return $this->playersPerTeam;
    }

    /**
     * @param int $playerPerTeam
     * @return $this
     */
    public function setPlayersPerTeam(int $playerPerTeam): self
    {
        $this->playersPerTeam = $playerPerTeam;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxTeams(): int
    {
        return $this->maxTeams;
    }

    /**
     * @param int $maxTeams
     * @return $this
     */
    public function setMaxTeams(int $maxTeams): self
    {
        $this->maxTeams = $maxTeams;
        return $this;
    }

    /**
     * @param string $teamColor
     * @param Position $position
     * @return void
     */
    public function setSpawnTeam(string $teamColor, Position $position): void
    {
        $this->spawnTeams[$teamColor] = $position;
    }
}