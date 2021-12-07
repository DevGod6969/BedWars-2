<?php

namespace bedwars\manager;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class ConfigManager extends Manager
{

    /** @var string */
    public string $default_lang;

    /**
     * @param PluginBase|null $plugin
     * @return void
     */
    public function init(?PluginBase $plugin): void
    {
        foreach (['players', 'lang'] as $directory) @mkdir($plugin->getDataFolder() . $directory);

        foreach (['config.yml', 'lang/en_US.yml'] as $file) $plugin->saveResource($file);
        # Default Config
        $config = $plugin->getConfig();

        $this->default_lang = $config->get('defualt_lang');

    }

    /**
     * @param string $direction
     * @param $type
     * @return Config
     */
    public function getConfig(string $direction, $type): Config
    {
        return new Config($direction, $type);
    }

    /**
     * @return Config
     */
    public function getDefault(): Config
    {
        return $this->plugin->getConfig();
    }

    /**
     * @return int
     */
    public function getPriority(): int
    {
        return ExtensionManager::PRIORITY_HIGH;
    }
}