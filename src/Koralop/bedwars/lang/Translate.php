<?php

namespace Koralop\bedwars\lang;

use pocketmine\utils\Config;

/**
 * Class Translate
 * @package Koralop\bedwars\lang
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