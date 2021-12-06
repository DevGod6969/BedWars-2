<?php

namespace bedwars\manager;

use bedwars\Loader;
use pocketmine\plugin\PluginBase;

/**
 *  @method static TranslationManager TRANSLATION()
 *  @method static ConfigManager CONFIG()
 */
final class ExtensionManager
{

    /** @var PluginBase|null */
    public static ?PluginBase $plugin = null;
    /** @var array */
    public static array $modules = [];

    const PRIORITY_HIGH = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_LOW  = 3;

    /**
     * @return bool
     */
    public static function isRegistered(): bool
    {
        if (self::$plugin == null && count(self::$modules) == 0) {
            return false;
        }
        return true;
    }

    /**
     * @param PluginBase $plugin
     * @return void
     */
    public static function register(PluginBase $plugin): void
    {
        self::$plugin = $plugin;

        $modules = [];
        $files = glob(__DIR__ . '*.php');

        foreach ($files as $file) {
            require($file);

            $classArchive = '\bedwars\manager\\' . basename($file, '.php');
            $class = new $classArchive();

            if ($class instanceof Manager && $class->getName() != 'Manager') {
                $modules[$class->getPriority()] = $class;
            }
        }

        arsort($modules);

        foreach ($modules as $priority => $class) {
            $class->isEnable = true;
            $class->plugin = self::$plugin;
            $class->init($class->plugin);
        }

        $plugin->getLogger()->info(Loader::PREFIX . 'The modules have been loaded successfully!');
    }
}