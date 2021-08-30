<?php

namespace Koralop\bedwars\commands;

use FormAPI\window\CustomWindowForm;
use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\entity\types\ShopEntity;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

/**
 * Class BedWarsCommand
 * @package Koralop\bedwars\commands
 */
class BedWarsCommand extends PluginCommand implements PluginIdentifiableCommand
{

    /**
     * BedWarsCommand constructor.
     * @param string $name
     * @param Plugin $owner
     */
    public function __construct(string $name, Plugin $owner)
    {
        parent::__construct($name, $owner);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender->isOp())
            return;

        if (!$sender instanceof BedWarsPlayer)
            return;


        if (empty($args[0])) {
            return;
        }

        switch ($args[0]) {
            case 'create':
                $sender->getSession()->setKit('Create');
                $sender->getSession()->setPlaceBed(true);

                $sender->sendMessage(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('starter.create.arena', $sender->getSession()->getLang())));
                break;
            case 'setshop':
                $nbt = Entity::createBaseNBT($sender);
                $nbt->setString('type', 'item');
                $human = new ShopEntity($sender->getLevel(), $nbt);
                $human->setNameTag('');
                $human->setNameTagVisible(true);
                $human->setNameTagAlwaysVisible(true);
                $human->yaw = $sender->getYaw();
                $human->pitch = $sender->getPitch();
                $human->spawnToAll();
                break;
            case 'setupdgrade':
                $nbt = Entity::createBaseNBT($sender);
                $nbt->setString('type', 'updgarde');
                $human = new ShopEntity($sender->getLevel(), $nbt);
                $human->setNameTag('');
                $human->setNameTagVisible(true);
                $human->setNameTagAlwaysVisible(true);
                $human->yaw = $sender->getYaw();
                $human->pitch = $sender->getPitch();
                $human->spawnToAll();
                break;
        }
    }
}