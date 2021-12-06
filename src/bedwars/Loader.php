<?php

namespace bedwars;

use pocketmine\plugin\PluginBase;

class Loader extends PluginBase
{

    /** @var Loader|null */
    public static ?Loader $instance = null;


    public function onEnable(): void
    {
        if (self::getInstance() == null)
            self::setInstance($this);
    }

    /**
     * @return Loader|null
     */
    public static function getInstance(): ?Loader
    {
        return self::$instance;
    }

    /**
     * @param Loader|null $instance
     */
    public static function setInstance(?Loader $instance): void
    {
        self::$instance = $instance;
    }
}