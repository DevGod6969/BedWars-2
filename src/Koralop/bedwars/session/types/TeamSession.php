<?php


namespace Koralop\bedwars\session\types;

use Koralop\bedwars\BedWarsPlayer;

/**
 * Class Team
 * @package Koralop\bedwars\game
 */
class TeamSession
{

    /** @var BedWarsPlayer[] $players */
    protected array $players = [];
    /** @var string $color */
    protected string $color;
    /** @var string $name */
    protected string $name;
    /** @var bool $hasBed */
    protected bool $hasBed = true;
    /** @var array $armorUpdates */
    private array $armorUpdates = [];
    /** @var int $dead */
    public int $dead = 0;
    /** @var array $upgrades */
    private array $upgrades = [
        'sharpenedSwords' => 0,
        'armorProtection' => 0
    ];


    /**
     * Team constructor.
     * @param string $name
     * @param string $color
     */
    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    /**
     * @param BedWarsPlayer $player
     */
    public function add(BedWarsPlayer $player): void
    {
        $this->players[$player->getXuid()] = $player;
    }

    public function remove(BedWarsPlayer $player): void
    {
        unset($this->players[$player->getXuid()]);
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @return int
     */
    public function getPlayerCount(): int
    {
        return count($this->players) - $this->dead;
    }

    /**
     * @param bool $state
     */
    public function updateBedState(bool $state): void
    {
        $this->hasBed = $state;
    }

    /**
     * @return bool
     */
    public function hasBed(): bool
    {
        return $this->hasBed;
    }

    /**
     * @param BedWarsPlayer $player
     * @param string $armor
     */
    public function setArmor(BedWarsPlayer $player, string $armor)
    {
        $this->armorUpdates[$player->getXuid()] = $armor;
    }

    /**
     * @param BedWarsPlayer $player
     * @return string|null
     */
    public function getArmor(BedWarsPlayer $player): ?string
    {
        return $this->armorUpdates[$player->getXuid()];
    }

    /**
     * @param string $property
     */
    public function upgrade(string $property): void
    {
        $this->upgrades[$property] += 1;
    }

    /**
     * @param string $property
     * @return int
     */
    public function getUpgrade(string $property): int
    {
        return $this->upgrades[$property];
    }

    public function reset(): void
    {
        $this->upgrades = [
            'sharpenedSwords' => 0,
            'armorProtection' => 0
        ];

        $this->hasBed = true;
        $this->armorUpdates = [];
        $this->players = [];
    }

    /**
     * @param BedWarsPlayer $player
     * @return bool
     */
    public function inTeam(BedWarsPlayer $player): bool
    {
        return isset($this->players[$player->getXuid()]);
    }
}