<?php

namespace bedwars\network;

use bedwars\api\scoreboard\ScoreboardIdentifier;
use bedwars\api\xp\XP;
use bedwars\commands\ArenaCommand;
use bedwars\commands\MainCommand;
use bedwars\events\PlayerListener;
use bedwars\events\SpawnListener;
use bedwars\kit\types\SpawnKit;
use bedwars\Loader;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use bedwars\network\data\PlayerData;
use bedwars\network\player\NetworkPlayer;

final class NetworkSession
{

    public static function startSession(): void
    {
        $plugin = Loader::getInstance();

        $plugin->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $plugin);
        $plugin->getServer()->getPluginManager()->registerEvents(new SpawnListener(), $plugin);

        $plugin->getServer()->getCommandMap()->registerAll('bedwars',
            [
                new ArenaCommand(),
                new MainCommand()
            ]);
    }

    /**
     * @param NetworkPlayer $player
     * @return void
     */
    public static function initPlayer(NetworkPlayer $player): void
    {
        # Player Data
        PlayerData::initializeData($player->getName());

        # Scoreboard
        ExtensionManager::getModule(ModulesIdentifier::SCOREBOARD_MANAGER)->add($player, ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate(['scoreboard', 'title']));
        $player->setScoreboard(ScoreboardIdentifier::SCOREBOARD_LOBBY, [
            '%online_players%' => count($player->getServer()->getOnlinePlayers()),
            '%level%' => XP::checkLevel($player->getName()),
            '%gadgetsmenu_mystery_boxes%' => PlayerData::getData($player->getName())->get('gadgetsmenu_mystery_boxes'),
            '%money%' => PlayerData::getData($player->getName())->get('money'),
            '%kills%' => PlayerData::getData($player->getName())->get('kills'),
            '%wins%' => PlayerData::getData($player->getName())->get('wins'),
            '%currentXp%' => XP::get($player->getName()),
            '%requiredXp%' => XP::getXpRequiredForLevel(XP::checkLevel($player->getName())),
            '%server_ip%' => ExtensionManager::getModule(ModulesIdentifier::CONFIG_MANAGER)->getDefault()->get('server')['ip'],
            '%progress%' => XP::getBarXP($player->getName())
        ]);

        # Items
        $player->getArmorInventory()->clearAll();
        $player->getInventory()->clearAll();

        # Add Kit
        new SpawnKit($player);

    }
}