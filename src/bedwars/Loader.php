<?php

namespace bedwars;

use bedwars\manager\ExtensionManager;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Loader extends PluginBase
{

    /** @var string */
    const PREFIX = TextFormat::BOLD . TextFormat::AQUA . 'BedWars ' . TextFormat::RESET . TextFormat::GRAY . '» ';
    /** @var Loader|null */
    public static ?Loader $instance = null;


    public function onEnable(): void
    {
        self::$instance = $this;

        if (!ExtensionManager::isRegistered())
            ExtensionManager::register($this);
    }

    /**
     * @return Loader|null
     */
    public static function getInstance(): ?Loader
    {
        return self::$instance;
    }
}