<?php

namespace bedwars\api\scoreboard;

interface ScoreboardIdentifier
{

    /** @var string */
    const SCOREBOARD_LOBBY = 'lobby';

    const SCOREBOARD_WAITING = 'waiting';
    const SCOREBOARD_STARTING = 'starting';
    const SCOREBOARD_PLAYING = 'playing';
}