<?php

namespace Koralop\bedwars\session\types;

use Koralop\bedwars\BedWarsPlayer;
use pocketmine\entity\EffectInstance;
use pocketmine\level\Position;

/**
 * Class CacheSession
 * @package Koralop\bedwars\session\types
 */
class CacheSession
{

    /** @var BedWarsPlayer|null $player */
    private ?BedWarsPlayer $player = null;
    /** @var string|null $nametag */
    private ?string $nametag;
    /** @var array|null $inventoryContents */
    private ?array $inventoryContents;
    /** @var int|null $health */
    private ?int $health;
    /** @var int|null $maxHealth */
    private ?int $maxHealth;
    /** @var int|null $food */
    private ?int $food;
    /** @var Position|null $position */
    private ?Position $position;
    /** @var EffectInstance[] $effects */
    private ?array $effects;

    public function __construct(BedWarsPlayer $player)
    {
        $this->nametag = $player->getNameTag();
        $this->inventoryContents = $player->getInventory()->getContents();
        $this->health = $player->getHealth();
        $this->maxHealth = $player->getMaxHealth();
        $this->food = $player->getMaxFood();
        $this->position = $player->asPosition();
        $this->effects = $player->getEffects();
    }

    public function load(): void
    {
        if ($this->player !== null) {
            $this->player->setNameTag($this->nametag);
            $this->player->getInventory()->setContents($this->inventoryContents);
            $this->player->setHealth($this->health);
            $this->player->setMaxHealth($this->maxHealth);
            $this->player->setFood($this->food);
            $this->player->teleport($this->position);
            foreach ($this->effects as $effect) {
                $this->player->addEffect($effect);
            }
        }
    }
}