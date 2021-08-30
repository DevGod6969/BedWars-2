<?php

namespace aaron2907\bedwars\session;

use aaron2907\bedwars\BedWarsPlayer;
use aaron2907\bedwars\session\types\CacheSession;
use aaron2907\bedwars\session\types\PlayerSession;
use aaron2907\bedwars\session\types\TeamSession;

/**
 * Class SessionManager
 * @package aaron2907\bedwars\session
 */
class SessionManager
{

    /** @var PlayerSession[] */
    protected array $sessions = [];
    /** @var CacheSession[] */
    protected array $cache = [];
    /** @var TeamSession[] */
    protected array $teams = [];

    /**
     * @param BedWarsPlayer $player
     */
    public function addSession(BedWarsPlayer $player): void
    {
        $this->sessions[$player->getXuid()] = new PlayerSession($player);
    }

    /**
     * @param BedWarsPlayer $player
     * @return PlayerSession|null
     */
    public function getSession(BedWarsPlayer $player): ?PlayerSession
    {
        return $this->sessions[$player->getXuid()];
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function isSession(BedWarsPlayer $player): bool
    {
        return isset($this->sessions[$player->getXuid()]);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function deleteSession(BedWarsPlayer $player): void
    {
        unset($this->sessions[$player->getName()]);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function addCache(BedWarsPlayer $player): void
    {
        $this->cache[$player->getXuid()] = new CacheSession($player);
    }

    /**
     * @param BedWarsPlayer $player
     * @return CacheSession|null
     */
    public function getCache(BedWarsPlayer $player): ?CacheSession
    {
        return $this->cache[$player->getXuid()];
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function isCache(BedWarsPlayer $player): bool
    {
        return isset($this->cache[$player->getXuid()]);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function deleteCache(BedWarsPlayer $player): void
    {
        unset($this->cache[$player->getName()]);
    }

    /**
     * @param string $name
     * @param string $color
     */
    public function addTeam(string $name, string $color)
    {
        $this->teams[$name] = new TeamSession($name, $color);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function isTeam(string $name): bool
    {
        return isset($this->teams[$name]);
    }

    /**
     * @param string $name
     * @return TeamSession
     */
    public function getTeam(string $name): TeamSession
    {
        return $this->teams[$name];
    }

    public function deleteTeam(string $name): void
    {
        unset($this->teams[$name]);
    }

    /**
     * @return TeamSession[]
     */
    public function getTeams(): array
    {
        return $this->teams;
    }
}