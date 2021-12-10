<?php

namespace bedwars\arena;

use pocketmine\Server;
use pocketmine\world\World;

final class ArenaOptions
{

    /** @var World|null */
    public ?World $world = null;
    /** @var bool */
    public bool $blockPlaced = true;
    /** @var bool */
    public bool $blockBreak = true;

    /**
     * @return static
     */
    public static function create(): self
    {
        return new self;
    }


    /**
     * @return World|null
     */
    public function getWorld(): ?World
    {
        return $this->world;
    }

    /**
     * @param $world
     * @return $this
     */
    public function setWorld($world): self
    {
        if ($world instanceof World) {
            $this->world = $world;
            return $this;
        }

        $world = Server::getInstance()->getWorldManager()->getWorldByName($world);

        if ($world == null) {
            return $this;
        }

        $this->world = $world;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBlockBreak(): bool
    {
        return $this->blockBreak;
    }

    /**
     * @return bool
     */
    public function isBlockPlaced(): bool
    {
        return $this->blockPlaced;
    }

    /**
     * @param bool $blockBreak
     * @return $this
     */
    public function setBlockBreak(bool $blockBreak): self
    {
        $this->blockBreak = $blockBreak;
        return $this;
    }

    /**
     * @param bool $blockPlaced
     * @return $this
     */
    public function setBlockPlaced(bool $blockPlaced): self
    {
        $this->blockPlaced = $blockPlaced;
        return $this;
    }
}