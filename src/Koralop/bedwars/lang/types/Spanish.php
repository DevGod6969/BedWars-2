<?php

namespace Koralop\bedwars\lang\types;

use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\lang\Translate;
use pocketmine\utils\Config;

/**
 * Class Spanish
 * @package Koralop\bedwars\lang\types
 */
class Spanish extends Translate
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Español';
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return new Config(BedWarsLoader::getInstance()->getDataFolder() . 'lang' . DIRECTORY_SEPARATOR . 'es-es.properties', Config::PROPERTIES);
    }
}