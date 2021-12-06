<?php

namespace bedwars\manager;

use pocketmine\plugin\PluginBase;

abstract class Manager
{

    /** @var bool */
    public bool $isEnable = false;
    /** @var PluginBase */
    public PluginBase $plugin;

    public function init(PluginBase $plugin): void
    {
    }

    public function save(PluginBase $plugin): void
    {
    }

    public function __destruct()
    {
        $this->save($this->plugin);
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
        return __CLASS__;
    }
}