<?php

namespace Koralop\bedwars\game;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\game\scheduler\GameScheduler;

/**
 * Class GameManager
 * @package Koralop\bedwars\game
 */
class GameManager
{

    /** @var int[] */
    public const STATUS = [
        'starting' => 0,
        'playing' => 1,
        'ending' => 2
    ];

    /** @var Game[] */
    private array $games = [];

    /**
     * GameManager constructor.
     */
    public function __construct()
    {
        BedWarsLoader::getInstance()->getScheduler()->scheduleRepeatingTask(new GameScheduler(), 20);
    }

    /**
     * @return Game[]
     */
    public function getGames(): array
    {
        return $this->games;
    }

    /**
     * @param array $data
     */
    public function addGame(array $data): void
    {
        $this->games[$data['name']] = new Game($data);
    }
}