<?php

namespace Koralop\bedwars\game;

use addon\lVector3;
use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\session\types\TeamSession;
use Koralop\bedwars\utils\Generator;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\TextFormat;

/**
 * Class Game
 * @package Koralop\bedwars\game
 */
class Game
{

    /** @var string|null */
    protected ?string $gameName;

    /** @var int */
    protected int $playersPerTeam = 1;
    /** @var BedWarsPlayer[] */
    protected array $spectators = [];
    /** @var BedWarsPlayer[] */
    protected array $players = [];
    /** @var TeamSession[] */
    protected array $teams = [];
    /** @var Level|null */
    protected ?Level $level = null;
    /** @var Vector3[] */
    protected array $spawn = [];
    /** @var TeamSession|null */
    protected ?TeamSession $teamWin = null;
    /** @var TeamSession[] */
    protected array $allTeams = [];
    /** @var Generator[] */
    protected array $generators = [];
    /** @var string|null */
    protected ?string $tierUpdateGen;

    /** @var int */
    protected int $time = 0;
    /** @var int */
    private int $status = GameManager::STATUS['starting'];

    /**
     * Game constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->gameName = $data['name'];

        if (isset($data['playerPerTeam']))
            $this->playersPerTeam = $data['playerPerTeam'];

        $this->spawn = $data['bed'];
        $this->level = $data['level'];
        $this->generators = $data['generators'];

        $this->teams[] = new TeamSession('red', 'red');
        $this->teams[] = new TeamSession('blue', 'blue');
        $this->teams[] = new TeamSession('yellow', 'yellow');
        $this->teams[] = new TeamSession('green', 'green');
    }

    /**
     * @param BedWarsPlayer $killer
     * @param BedWarsPlayer $dead
     */
    public function playerDeath(BedWarsPlayer $killer, BedWarsPlayer $dead): void
    {
        if (!$dead->getSession()->getTeam()->hasBed())
            $this->setSpectator($dead);

        /** @var BedWarsPlayer[] $alive */
        $alive = [];

        foreach ($dead->getSession()->getTeam()->getPlayers() as $player)
            if ($this->isSpectator($player))
                $alive[] = $player;

        if (count($alive) == $this->playersPerTeam)
            $this->removeTeam($dead->getSession()->getTeam()->getColor());

        $dead->getSession()->getTeam()->dead = $dead->getSession()->getTeam()->dead + 1;

        $this->removePlayer($dead);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function setSpectator(BedWarsPlayer $player): void
    {
        $this->spectators[$player->getXuid()] = $player;

        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();

        $player->setGamemode(3);
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function isSpectator(BedWarsPlayer $player): bool
    {
        return isset($this->spectators[$player->getXuid()]);
    }

    public function tick(): void
    {
        switch ($this->status) {
            case GameManager::STATUS['starting']:
                if (count($this->players) == $this->playersPerTeam * 4) {

                    foreach ($this->players as $xuid => $player) {

                        if (!$player->getSession()->inTeam()) {
                            $team = $this->availableTeam();

                            if ($team != null)
                                $this->joinTeam($player, $team);
                            else
                                $this->removePlayer($player);
                        }
                    }

                    $this->startGame();
                    $this->status = GameManager::STATUS['playing'];
                }

                foreach ($this->players as $player)
                    if ($player->getSession()->getScoreboardType() != 'queue')
                        $player->getSession()->setScoreboardType('queue');

                break;
            case GameManager::STATUS['playing']:
                if (count($this->getTeamsAlive()) == 0)
                    $this->status = GameManager::STATUS['ending'];

                foreach ($this->players as $player)
                    if ($player->getSession()->getScoreboardType() != 'playing')
                        $player->getSession()->setScoreboardType('playing');

                foreach ($this->generators as $generator)
                    $generator->tick();

                break;
            case GameManager::STATUS['ending']:
                BedWarsLoader::getInstance()->getScheduler()->scheduleDelayedTask(new ClosureTask(function (int $currentTick) {
                    if ($this->teamWin == null)
                        return;

                    $team = $this->teamWin;

                    foreach ($team->getPlayers() as $player)
                        $player->spawn();

                }), 20 * 10);
                break;
        }

        if ($this->status != GameManager::STATUS['starting'])
            $this->time++;
    }

    /**
     * @param BedWarsPlayer $player
     * @param TeamSession $session
     */
    public function joinTeam(BedWarsPlayer $player, TeamSession $session): void
    {
        $session->add($player);
    }

    /**
     * @return TeamSession|null
     */
    public function availableTeam(): ?TeamSession
    {
        foreach ($this->teams as $team) {
            if (count($team->getPlayers()) < $this->playersPerTeam)
                return $team;
        }
        return null;
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function addPlayer(BedWarsPlayer $player): void
    {
        $player->teleport($this->level->getSpawnLocation());
        $player->getSession()->setKit('Queue');

        $this->players[$player->getXuid()] = $player;
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function isPlayer(BedWarsPlayer $player): bool
    {
        foreach ($this->players as $xuid => $bedWarsPlayer) {
            if ($xuid == $player->getXuid())
                return true;
        }
        return false;
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function removePlayer(BedWarsPlayer $player): void
    {
        unset($this->players[$player->getXuid()]);
    }

    /**
     * @return BedWarsPlayer[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return TeamSession[]
     */
    public function getTeamsAlive(): array
    {
        return $this->teams;
    }

    /**
     * @param TeamSession $session
     */
    public function addTeam(TeamSession $session): void
    {
        $this->allTeams[$session->getColor()] = $session;

        $this->teams[$session->getColor()] = $session;
    }

    /**
     * @param string $color
     */
    public function removeTeam(string $color): void
    {
        unset($this->teams[$color]);
    }

    /**
     * @param string $color
     * @return bool
     */
    public function isTeam(string $color): bool
    {
        return isset($this->teams[$color]);
    }

    public function endGame(): void
    {
        $this->players = [];
        $this->teams = [];
        $this->spectators = [];

        $this->teamWin = null;

        $this->time = 0;
    }

    /**
     * @return int|null
     */
    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function startGame(): void
    {
        $level = $this->getLevel()->getFolderName();
        try {
            $zip = new \ZipArchive();

            $zip->open(BedWarsLoader::getInstance()->getDataFolder() . 'arenas' . DIRECTORY_SEPARATOR . $level . '.zip', \ZipArchive::CREATE);

            $files = glob(BedWarsLoader::getInstance()->getServer()->getDataPath() . 'worlds' . DIRECTORY_SEPARATOR . $level . DIRECTORY_SEPARATOR . 'region' . DIRECTORY_SEPARATOR . '*.mcapm');

            foreach ($files as $file)
                $zip->addFile($file, 'region' . DIRECTORY_SEPARATOR . str_replace('.mcamp', '', basename($file)));

            $zip->addFile(BedWarsLoader::getInstance()->getServer()->getDataPath() . 'worlds' . DIRECTORY_SEPARATOR . $level . DIRECTORY_SEPARATOR . 'level.dat', 'level.dat');
            $zip->close();

            BedWarsLoader::getInstance()->getLogger()->info(TextFormat::colorize(str_replace('{map}', $level, BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('correctly.compress.arena', BedWarsLoader::getInstance()->getYamlProvider()->getConfig()->get('default.lang')))));
        } catch (\Exception $exception) {
            BedWarsLoader::getInstance()->getLogger()->error(TextFormat::colorize(str_replace('{map}', $level, BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('failed.compress.arena', BedWarsLoader::getInstance()->getYamlProvider()->getConfig()->get('default.lang')))));
        }

        foreach ($this->getTeamsAlive() as $session) {
            foreach ($session->getPlayers() as $player)
                $player->teleport($this->spawn[$session->getColor()]);
        }
    }

    /**
     * @return Level
     */
    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * @return int
     */
    public function getPlayerPerTeam(): int
    {
        return $this->playersPerTeam;
    }

    /**
     * @return TeamSession[]
     */
    public function getTeams(): array
    {
        return $this->allTeams;
    }

    /**
     * @param lVector3 $vector3
     * @return TeamSession|null
     */
    public function getTeamByBedPosition(lVector3 $vector3): ?TeamSession
    {
        foreach ($this->spawn as $bed => $vector3) {
            if ($vector3->getFloorX() == $vector3->getFloorX())
                return $this->getTeamByColor($bed);
        }
        return null;
    }

    /**
     * @param string $color
     * @return TeamSession|null
     */
    public function getTeamByColor(string $color): ?TeamSession
    {
        foreach ($this->teams as $session) {
            if ($session->getColor() == $color)
                return $session;
        }
        return null;
    }
}