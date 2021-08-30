<?php

namespace Koralop\bedwars\provider;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use pocketmine\utils\Config;

/**
 * Class YamlProvider
 * @package Koralop\bedwars\provider
 */
class YamlProvider
{

    /**
     * YamlProvider constructor.
     */
    public function __construct()
    {
        BedWarsLoader::getInstance()->saveResource('config.yml');
        @mkdir(BedWarsLoader::getInstance()->getDataFolder() . 'data');
        @mkdir(BedWarsLoader::getInstance()->getDataFolder() . 'arenas');
        @mkdir(BedWarsLoader::getInstance()->getDataFolder() . 'data' . DIRECTORY_SEPARATOR . 'players');
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return BedWarsLoader::getInstance()->getConfig();
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function createPlayer(BedWarsPlayer $player): void
    {
        new Config(BedWarsLoader::getInstance()->getDataFolder() . 'data' . DIRECTORY_SEPARATOR . 'players' . DIRECTORY_SEPARATOR . $player->getXuid() . '.yml', Config::YAML, [
            'lang' => $this->getConfig()->get('default.lang')
        ]);
    }

    /**
     * @param BedWarsPlayer $player
     * @return Config
     */
    public function getPlayer(BedWarsPlayer $player): Config
    {
        return new Config(BedWarsLoader::getInstance()->getDataFolder() . 'data' . DIRECTORY_SEPARATOR . 'players' . DIRECTORY_SEPARATOR . $player->getXuid() . '.yml', Config::YAML);
    }

    /**
     * @return Config
     */
    public function getWins(): Config
    {
        return new Config(BedWarsLoader::getInstance()->getDataFolder() . 'wins.yml', Config::YAML);
    }

    /**
     * @return Config
     */
    public function getKills(): Config
    {
        return new Config(BedWarsLoader::getInstance()->getDataFolder() . 'kills.yml', Config::YAML);
    }
}