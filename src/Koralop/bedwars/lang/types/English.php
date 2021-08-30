<?php

namespace Koralop\bedwars\lang\types;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\lang\Translate;
use pocketmine\utils\Config;

/**
 * Class English
 * @package Koralop\bedwars\lang\types
 */
class English extends Translate
{

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return new Config(BedWarsLoader::getInstance()->getDataFolder() . 'lang' . DIRECTORY_SEPARATOR . 'en-in.properties', Config::PROPERTIES);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'English';
    }
}