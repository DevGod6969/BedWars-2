<?php

namespace bedwars;

use bedwars\manager\ExtensionManager;
use bedwars\network\NetworkSession;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

class Loader extends PluginBase
{

    /** @var string */
    const PREFIX = TextFormat::BOLD . TextFormat::YELLOW . 'BedWars ' . TextFormat::RESET . TextFormat::GRAY . '» ';
    const VERSION = '0.1';
    /** @var Loader|null */
    public static ?Loader $instance = null;


    public function onEnable(): void
    {
        self::$instance = $this;


        if (!ExtensionManager::isRegistered())
            ExtensionManager::register($this);

        NetworkSession::startSession();

        $this->getLogger()->info(' ');
        $this->getLogger()->info(TextFormat::GRAY . '----------------------------');
        $this->getLogger()->info(TextFormat::BOLD . TextFormat::YELLOW . '          BedWars          ');
        $this->getLogger()->info(' ');
        $this->getLogger()->info('Author: Koralop#9999');
        $this->getLogger()->info('Version: ' . self::VERSION);
        $this->getLogger()->info(' ');
        $this->getLogger()->info(TextFormat::GRAY . '----------------------------');
        $this->getLogger()->info(' ');
    }

    /**
     * @return Loader|null
     */
    public static function getInstance(): ?Loader
    {
        return self::$instance;
    }
}