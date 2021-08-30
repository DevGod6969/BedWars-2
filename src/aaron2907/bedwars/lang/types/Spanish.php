<?php

namespace aaron2907\bedwars\lang\types;

use aaron2907\bedwars\BedWarsLoader;
use aaron2907\bedwars\lang\Translate;
use pocketmine\utils\Config;

/**
 * Class Spanish
 * @package aaron2907\bedwars\lang\types
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