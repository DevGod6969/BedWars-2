<?php

namespace aaron2907\bedwars\lang;

use pocketmine\utils\Config;

/**
 * Class Translate
 * @package aaron2907\bedwars\lang
 */
abstract class Translate
{

    /**
     * @return Config
     */
    abstract function getConfig(): Config;

    /**
     * @return string
     */
    abstract function getName(): string;
}