<?php

namespace bedwars\manager;

use bedwars\game\team\TeamSession;

class TeamManager extends Manager
{

    /** @var TeamSession[] */
    public array $teams = [];

    /**
     * @param string $color
     * @return TeamSession
     */
    public function add(string $color): TeamSession
    {
        $identifier = count($this->teams);

        $team = new TeamSession($color, $identifier);

        return $team;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function searchTeamById(int $id): bool
    {
        return isset($this->teams[$id]);
    }
}