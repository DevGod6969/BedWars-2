<?php

namespace Koralop\bedwars;

use Koralop\bedwars\commands\BedWarsCommand;
use Koralop\bedwars\entity\EntityManager;
use Koralop\bedwars\game\GameListener;
use Koralop\bedwars\game\GameManager;
use Koralop\bedwars\kit\KitManager;
use Koralop\bedwars\lang\TranslateManager;
use Koralop\bedwars\provider\YamlProvider;
use Koralop\bedwars\scoreboard\ScoreboardManager;
use Koralop\bedwars\session\SessionManager;
use pocketmine\plugin\PluginBase;

/**
 * Class BedWarsLoader
 * @package Koralop\bedwars
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