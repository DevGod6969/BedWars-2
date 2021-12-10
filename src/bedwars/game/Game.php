<?php

namespace bedwars\game;

use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\game\team\TeamSession;
use bedwars\game\utils\lSpectator;
use bedwars\Loader;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\player\NetworkPlayer;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;

class Game
{

    /** @var string */
    public string $name;
    /** @var lSpectator[] */
    public array $spectators = [];
    /** @var TeamSession[] */
    public array $teams = [];
    /** @var NetworkPlayer[] */
    public array $players = [];
    /** @var string */
    public string $status = GameStatus::WAITING;
    /** @var GameOptions */
    public GameOptions $options;
    /** @var int */
    public int $time = -1;

    /**
     * @param string $name
     * @param GameOptions $options
     */
    public function __construct(string $name, GameOptions $options)
    {
        $this->name = $name;
        $this->options = $options;

        Loader::getInstance()->getScheduler()->scheduleRepeatingTask(new ClosureTask(function (): void {
            $this->tick();
        }), 20);
    }


    public function tick(): void
    {
        switch ($this->getStatus()) {
            case GameStatus::WAITING:
                if (count($this->players) >= ($this->getOptions()->getMaxTeams() * ($this->getOptions()->getPlayersPerTeam() % 2))) {
                    if ($this->time == -1) {
                        $this->time = 15;
                    }

                    if ($this->time == 0) {
                        $this->setStatus(GameStatus::PLAYING);
                    }

                    $this->updateScoreboard();
                    $this->time--;
                    return;
                } else
                    $this->time = -1;
                break;
        }
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return GameOptions
     */
    public function getOptions(): GameOptions
    {
        return $this->options;
    }

    /**
     * @return NetworkPlayer[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param NetworkPlayer $player
     * @return void
     */
    public function addPlayer(NetworkPlayer $player): void
    {
        $this->players[$player->getXuid()] = $player;

        $this->updateScoreboard();
    }

    /**
     * @return void
     */
    public function updateScoreboard(): void
    {
        foreach ($this->getPlayers() as $player) {
            $player->setScoreboard(ScoreboardIdentifier::SCOREBOARD_WAITING, [
                '%server_ip%' => ExtensionManager::getModule(ModulesIdentifier::CONFIG_MANAGER)->getDefault()->get('server')['ip'],
                '%on%' => count($this->getPlayers()),
                '%max%' => $this->getOptions()->getMaxTeams() * ($this->getOptions()->getPlayersPerTeam()),
                '%map%' => $this->getOptions()->getArena()->getOptions()->getWorld()->getDisplayName(),
                '%group%' => $this->getOptions()->getPlayersPerTeam() . str_repeat('v' . $this->getOptions()->getPlayersPerTeam(), $this->getOptions()->getMaxTeams() - 1),
                '%date%' => date('m-d-y')
            ]);
        }
    }
}