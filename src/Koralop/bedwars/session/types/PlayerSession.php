<?php

namespace Koralop\bedwars\session\types;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\game\Game;

/**
 * Class PlayerSession
 * @package Koralop\bedwars\session\types
 */
class PlayerSession
{

    /** @var BedWarsPlayer|null */
    private ?BedWarsPlayer $player = null;

    /** @var string */
    protected string $score = 'spawn';
    /** @var bool */
    protected bool $placeBed = false;
    /** @var array */
    public array $createArena = [];

    /**
     * PlayerSession constructor.
     * @param BedWarsPlayer $player
     */
    public function __construct(BedWarsPlayer $player)
    {
        $this->player = $player;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return BedWarsLoader::getInstance()->getYamlProvider()->getPlayer($this->player)->get('lang');
    }

    /**
     * @param string $lang
     */
    public function setLang(string $lang): void
    {
        $data = BedWarsLoader::getInstance()->getYamlProvider()->getPlayer($this->player);
        $data->set('lang', $lang);
        $data->save();
    }

    /**
     * @param string $kitName
     */
    public function setKit(string $kitName): void
    {
        BedWarsLoader::getInstance()->getKitManager()->setKit($this->player, $kitName);
    }

    /**
     * @return string
     */
    public function getScoreboardType(): string
    {
        return $this->score;
    }

    /**
     * @param string $score
     */
    public function setScoreboardType(string $score): void
    {
        $this->score = $score;
    }

    /**
     * @return TeamSession|null
     */
    public function getTeam(): ?TeamSession
    {
        foreach (BedWarsLoader::getInstance()->getSessionManager()->getTeams() as $team) {
            if (in_array($this->player->getXuid(), $team->getPlayers()))
                return $team;
        }
        return null;
    }

    /**
     * @return Game|null
     */
    public function getGame(): ?Game
    {
        foreach (BedWarsLoader::getInstance()->getGameManager()->getGames() as $game) {
            if ($game->isPlayer($this->player))
                return $game;
        }
        return null;
    }

    /**
     * @return bool
     */
    public function inTeam(): bool
    {
        foreach (BedWarsLoader::getInstance()->getSessionManager()->getTeams() as $team) {
            if ($team->inTeam($this->player))
                return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isPlaceBed(): bool
    {
        return $this->placeBed;
    }

    /**
     * @param bool $bool
     */
    public function setPlaceBed(bool $bool): void
    {
        $this->placeBed = $bool;
    }
}