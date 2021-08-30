<?php

namespace aaron2907\bedwars\lang\types;

use aaron2907\bedwars\BedWarsLoader;
use aaron2907\bedwars\lang\Translate;
use pocketmine\utils\Config;

/**
 * Class English
 * @package aaron2907\bedwars\lang\types
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