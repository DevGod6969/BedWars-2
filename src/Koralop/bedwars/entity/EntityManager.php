<?php

namespace Koralop\bedwars\entity;

use Koralop\bedwars\entity\types\ShopEntity;
use pocketmine\entity\Entity;

/**
 * Class EntityManager
 * @package Koralop\bedwars\entity
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