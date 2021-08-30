<?php

namespace Koralop\bedwars\kit;

use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\kit\types\CreateKit;
use Koralop\bedwars\kit\types\QueueKit;
use Koralop\bedwars\kit\types\SpawnKit;

/**
 * Class KitManager
 * @package Koralop\bedwars\kit
 */
class KitManager
{

    /** @var Kit[] */
    private array $kit = [];


    /**
     * KitManager constructor.
     */
    public function __construct()
    {
        $kits = [
            new SpawnKit(),
            new QueueKit(),
            new CreateKit()
        ];

        foreach ($kits as $kit)
            $this->addKit($kit);
    }

    /**
     * @param Kit $kit
     */
    public function addKit(Kit $kit): void
    {
        $this->kit[$kit->getName()] = $kit;
    }

    /**
     * @param string $kitName
     * @return bool
     */
    public function isKit(string $kitName): bool
    {
        return isset($this->kit[$kitName]);
    }

    public function getKit(string $kitName): Kit
    {
        return $this->kit[$kitName];
    }

    /**
     * @param string $kitName
     */
    public function deleteKit(string $kitName): void
    {
        unset($this->kit[$kitName]);
    }

    /**
     * @param BedWarsPlayer $player
     * @param string $kitName
     */
    public function setKit(BedWarsPlayer $player, string $kitName): void
    {
        if (!$this->isKit($kitName))
            return;

        $kit = $this->getKit($kitName);

        $player->getInventory()->clearAll();
        $player->getArmorInventory()->clearAll();

        $player->getInventory()->setContents($kit->getItems($player));
        $player->getArmorInventory()->setContents($kit->getArmor($player));
    }
}