<?php

namespace bedwars\commands;

use bedwars\api\form\CustomForm;
use bedwars\game\GameOptions;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\player\NetworkPlayer;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\Translatable;
use pocketmine\Server;

class MainCommand extends Command
{

    public function __construct()
    {
        parent::__construct('bedwars');
        $this->setAliases(['bw']);
    }

    /**
     * @param CommandSender $sender
     * @param string $commandLabel
     * @param array $args
     */
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!$sender instanceof NetworkPlayer) {
            $sender->sendMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('only-in-game'));
            return;
        }

        if (!Server::getInstance()->isOp($sender->getName())) {
            $sender->sendMessage(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('no-permission'));
            return;
        }

        if (empty($args[0])) {
            foreach (ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getArrayTranslation('cmd-main-list') as $message)
                $sender->sendMessage($message);
            return;
        }

        switch ($args[0]) {
            case 'create':
                $arenas = [];
                foreach (ExtensionManager::getModule(ModulesIdentifier::ARENA_MANAGER)->getArenas() as $arena)
                    $arenas[] = $arena;


                $form = new CustomForm(function (NetworkPlayer $player, $data) use ($arenas): void {
                    ExtensionManager::getModule(ModulesIdentifier::GAME_MANAGER)->add(
                        name: $data[0],
                        options: GameOptions::create()
                            ->setArena($arenas[$data[1]])
                            ->setPlayersPerTeam($data[1])
                            ->setMaxTeams($data[2]));
                });
                $form->setTitle('Create');
                $form->addInput('Game Name');
                $form->addDropdown('Arena', array_filter($arenas, function ($arena) {
                    return $arena->getName();
                }));
                $form->addSlider('Players Per Team', 1, 4);
                $form->addSlider('Max Teams', 2, 8);
                $sender->sendForm($form);
                break;
            case 'join':
                if (empty($args[1])) {
                    return;
                }

                ExtensionManager::getModule(ModulesIdentifier::GAME_MANAGER)->get($args[1])->addPlayer($sender);
                break;
        }
    }
}