<?php

namespace bedwars\manager;

use pocketmine\plugin\PluginBase;

abstract class Manager
{

    /** @var bool */
    public bool $isEnable = false;
    /** @var PluginBase|null */
    public ?PluginBase $plugin = null;
    /** @var string */
    public string $name;

    public function __construct()
    {
        $this->name = __CLASS__;
    }

    public function init(?PluginBase $plugin): void
    {
    }

    public function save(?PluginBase $plugin): void
    {
    }

    public function __destruct()
    {
        if ($this->plugin != null)
            $this->save($this->plugin);

        $this->isEnable = false;
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return ExtensionManager::PRIORITY_NORMAL;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}