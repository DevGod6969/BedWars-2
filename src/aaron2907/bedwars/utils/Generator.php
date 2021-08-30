<?php

namespace aaron2907\bedwars\utils;

use pocketmine\item\Item;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

/**
 * Class Generator
 * @package aaron2907\bedwars\utils
 */
class Generator extends Vector3
{

    /** @var string[] */
    const TITLE = [
        Item::DIAMOND => TextFormat::BOLD . TextFormat::AQUA . 'Diamond',
        Item::EMERALD => TextFormat::BOLD . TextFormat::GREEN . 'Emerald'
    ];

    /** @var int $itemID */
    public int $itemID;
    /** @var int $repeatRate */
    private int $repeatRate;
    /** @var Position|null $position */
    public ?Position $position;
    /** @var bool $spawnText */
    private bool $spawnText = false;
    /** @var int $dynamicSpawnTime */
    private int $dynamicSpawnTime;
    /** @var FloatingTextParticle|null $floatingText */
    private ?FloatingTextParticle $floatingText;
    /** @var int $tier */
    private int $tier = 1;
    /** @var bool */
    private bool $activated = false;

    /**
     * Generator constructor.
     * @param int $itemID
     * @param int $repeatRate
     * @param Position $position
     * @param bool $spawnText
     * @param bool $activated
     */
    public function __construct(int $itemID, int $repeatRate, Position $position, bool $spawnText, bool $activated = true)
    {
        parent::__construct($position->x, $position->y, $position->z);
        $this->itemID = $itemID;
        $this->repeatRate = $repeatRate;
        $this->position = $position;
        $this->spawnText = $spawnText;

        $this->dynamicSpawnTime = $repeatRate;

        if ($this->spawnText) {
            $text = TextFormat::YELLOW . 'Tier ' . TextFormat::RED . BedWarsUtils::rome($this->tier) . '\n' .
                self::TITLE[$itemID] . '\n\n' .
                TextFormat::YELLOW . 'Spawns in ' . TextFormat::RED . $this->dynamicSpawnTime . 'seconds';
            $this->floatingText = new FloatingTextParticle($position->add(0, 2.5, 0), $text, '');
        }
        $this->activated = $activated;
    }


    /**
     * @param int $repeatRate
     */
    public function setRepeatRate(int $repeatRate): void
    {
        $this->repeatRate = $repeatRate;
    }

    public function tick(): void
    {
        if ($this->spawnText) {
            $text = TextFormat::YELLOW . 'Tier ' . TextFormat::RED . BedWarsUtils::rome($this->tier) . '\n' .
                self::TITLE[$this->itemID] . '\n' .
                TextFormat::YELLOW . 'Spawn in ' . TextFormat::RED . $this->dynamicSpawnTime;
            $this->floatingText->setText($text);
            foreach ($this->floatingText->encode() as $packet) {
                foreach ($this->position->getLevel()->getPlayers() as $player) {
                    $player->dataPacket($packet);
                }
            }
        }

        if ($this->dynamicSpawnTime == 0) {
            $this->dynamicSpawnTime = $this->repeatRate;
            if ($this->activated) {
                $this->position->getLevel()->dropItem($this->position->asVector3(), Item::get($this->itemID));
            }
        }

        $this->dynamicSpawnTime--;

    }

    /**
     * @return int
     */
    public function getTier(): int
    {
        return $this->tier;
    }

    public function updateTier(): void
    {
        $this->tier++;

        $this->repeatRate = $this->repeatRate - 10;
    }

    /**
     * @return FloatingTextParticle|null
     */
    public function getFloatingText(): ?FloatingTextParticle
    {
        return $this->floatingText;
    }
}