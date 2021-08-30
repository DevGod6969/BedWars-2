<?php

namespace aaron2907\bedwars\entity;

use aaron2907\bedwars\entity\types\ShopEntity;
use pocketmine\entity\Entity;

/**
 * Class EntityManager
 * @package aaron2907\bedwars\entity
 */
class EntityManager
{

    /**
     * EntityManager constructor.
     */
    public function __construct()
    {
        Entity::registerEntity(ShopEntity::class, true);
    }
}