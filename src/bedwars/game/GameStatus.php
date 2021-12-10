<?php

namespace bedwars\game;

interface GameStatus
{

    public const WAITING = 'WAITING';
    public const STARTING = 'STARTING';
    public const PLAYING = 'PLAYING';
    public const FINISHED = 'FINISHED';
    public const RESTORING = 'RESTORING';

}