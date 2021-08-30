<?php

namespace aaron2907\bedwars\entity\types;

use pocketmine\entity\Villager;

/**
 * Class ShopEntity
 * @package aaron2907\bedwars\entity\types
 */
class ShopEntity extends Villager
{

    /**
     * @return string
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->namedtag->getString('type');
    }
}