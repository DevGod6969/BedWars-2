<?php

namespace bedwars\manager;

use bedwars\Loader;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;

final class ExtensionManager
{

    /** @var PluginBase|null */
    public static ?PluginBase $plugin = null;
    /** @var array */
    public static array $modules = [];

    const PRIORITY_HIGH = 1;
    const PRIORITY_NORMAL = 2;
    const PRIORITY_LOW = 3;

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
        $files = glob(__DIR__ . DIRECTORY_SEPARATOR . '*.php');

        foreach ($files as $file) {
            $fileName = basename($file, '.php');

            if ($fileName != 'Manager' && $fileName != 'ModulesIdentifier') {
                $classArchive = "\bedwars\manager\\$fileName";
                $class = new $classArchive();

                if ($class instanceof Manager) {
                    $class->name = $fileName;
                    $modules[$class->getPriority()][] = $class;
                    self::$modules[$class->getName()] = $class;
                }
            }
        }

        foreach ([self::PRIORITY_HIGH, self::PRIORITY_NORMAL, self::PRIORITY_LOW] as $priority) {
            foreach ($modules[$priority] as $priority => $class) {
                $class->isEnable = true;
                $class->plugin = self::$plugin;
                $class->init($class->plugin);
            }
        }

        $plugin->getLogger()->info(Loader::PREFIX . TextFormat::DARK_GREEN . 'The modules have been loaded successfully!');
    }

    /**
     * @param $name
     * @return Manager
     */
    public static function getModule($name): Manager
    {
        return self::$modules[$name];
    }
}