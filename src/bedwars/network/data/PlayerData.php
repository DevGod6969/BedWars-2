<?php

namespace bedwars\network\data;

use bedwars\Loader;
use pocketmine\utils\Config;

final class PlayerData
{

    /**
     * @param string $playerName
     * @return Config
     */
    public static function getData(string $playerName): Config
    {
        return new Config(Loader::getInstance()->getDataFolder() . "players/$playerName.yml", Config::YAML);
    }

    /**
     * @param string $playerName
     * @return void
     */
    public static function initializeData(string $playerName): void
    {
        new Config(Loader::getInstance()->getDataFolder() . "players/$playerName.yml", Config::YAML, [
            'level' => 1,
            'loot_chest' => 0,
            'coins' => 0,
            'kills' => 0,
            'wins' => 0,
            'god' => false
        ]);
    }
}