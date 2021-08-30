<?php

namespace aaron2907\bedwars;

use aaron2907\bedwars\commands\BedWarsCommand;
use aaron2907\bedwars\entity\EntityManager;
use aaron2907\bedwars\game\GameListener;
use aaron2907\bedwars\game\GameManager;
use aaron2907\bedwars\kit\KitManager;
use aaron2907\bedwars\lang\TranslateManager;
use aaron2907\bedwars\provider\YamlProvider;
use aaron2907\bedwars\scoreboard\ScoreboardManager;
use aaron2907\bedwars\session\SessionManager;
use pocketmine\plugin\PluginBase;

/**
 * Class BedWarsLoader
 * @package aaron2907\bedwars
 */
class BedWarsLoader extends PluginBase
{

    /** @var BedWarsLoader|null */
    private static ?BedWarsLoader $loader = null;

    /** @var array|null */
    private ?array $data;

    public function onEnable()
    {
        self::$loader = $this;

        $this->getServer()->getCommandMap()->register('bedwars', new BedWarsCommand('bedwars', $this));

        $this->getServer()->getPluginManager()->registerEvents(new BedWarsListener(), $this);
        $this->getServer()->getPluginManager()->registerEvents(new GameListener(), $this);

        $this->data['yamlProvider'] = new YamlProvider;
        $this->data['sessionManager'] = new SessionManager;
        $this->data['scoreboardManager'] = new ScoreboardManager;
        $this->data['translateManager'] = new TranslateManager;
        $this->data['kitManager'] = new KitManager;
        $this->data['entityManager'] = new EntityManager;
        $this->data['gameManager'] = new GameManager;
    }

    /**
     * @return static|null
     */
    public static function getInstance(): ?self
    {
        return self::$loader;
    }

    /**
     * @return SessionManager|null
     */
    public function getSessionManager(): ?SessionManager
    {
        return $this->data['sessionManager'];
    }

    /**
     * @return ScoreboardManager|null
     */
    public function getScoreboardManager(): ?ScoreboardManager
    {
        return $this->data['scoreboardManager'];
    }

    /**
     * @return TranslateManager
     */
    public function getTranslateManager(): TranslateManager
    {
        return $this->data['translateManager'];
    }

    /**
     * @return YamlProvider
     */
    public function getYamlProvider(): YamlProvider
    {
        return $this->data['yamlProvider'];
    }

    /**
     * @return KitManager
     */
    public function getKitManager(): KitManager
    {
        return $this->data['kitManager'];
    }

    /**
     * @return GameManager
     */
    public function getGameManager(): GameManager
    {
        return $this->data['gameManager'];
    }
}