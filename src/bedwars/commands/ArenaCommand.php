<?php

namespace bedwars\commands;

use bedwars\arena\ArenaOptions;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\console\ConsoleCommandSender;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\Server;

class ArenaCommand extends Command
{

    public function __construct()
    {
        parent::__construct('arena');
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!Server::getInstance()->isOp($sender->getName())) {
            if (!$sender instanceof ConsoleCommandSender) {
                $sender->sendMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('no-permission'));
                return;
            }
        }

        if (empty($args[0])) {
            return;
        }

        switch ($args[0]) {
            case 'create':
                if (empty($args[1]) || empty($args[2])) {
                    if ($sender instanceof Player) {
                        if (empty($args[1])) {
                            $sender->sendMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('cmd-arena-usage', ['%data%' => '[string: arenaName]']));
                            return;
                        }

                        $arena = ExtensionManager::getModule(ModulesIdentifier::ARENA_MANAGER)->getArenaByName($args[1]);

                        if ($arena != null) {
                            return;
                        }

                        ExtensionManager::getModule(ModulesIdentifier::ARENA_MANAGER)->create(
                            $args[1],
                             ArenaOptions::create()
                                ->setWorld($sender->getWorld())
                                ->setBlockBreak(true)
                                ->setBlockPlaced(true)
                        );
                    } else {
                        $sender->sendMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('cmd-arena-usage', ['%data%' => '[string: arenaName] [string: worldName]']));
                    }
                    return;
                }
                break;
            case 'list':
                $message = '';
                foreach (ExtensionManager::getModule(ModulesIdentifier::ARENA_MANAGER)->getArenas() as $arena) {
                    $message .= ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->colorize('&7' . $arena->getName() . ' &8(' . ($arena->isLoad() ? '&aLoad' : '&cNo-Load') . '&8)') . PHP_EOL;
                }
                $sender->sendMessage($message);
                break;
        }
    }
}