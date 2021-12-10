<?php

namespace bedwars\kit\types;

use bedwars\kit\Kit;
use bedwars\manager\ExtensionManager;
use bedwars\manager\ModulesIdentifier;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;

class SpawnKit extends Kit
{

    public function getItems(): array
    {
        $compass = ItemFactory::getInstance()->get(ItemIds::COMPASS, 0);
        $compass->setCustomName(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('lobby-items-compass-name'));
        $compass->setLore(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getArrayTranslation('lobby-items-compass-lore'));

        $skull = ItemFactory::getInstance()->get(ItemIds::SKULL, 0);
        $skull->setCustomName(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('lobby-items-skull-name'));

        $star = ItemFactory::getInstance()->get(ItemIds::NETHER_STAR, 0);
        $star->setCustomName(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('lobby-items-selector-name'));
        $star->setLore(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getArrayTranslation('lobby-items-selector-lore'));

        $chest = ItemFactory::getInstance()->get(ItemIds::CHEST, 0);
        $chest->setCustomName(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getMessageTranslate('lobby-items-language-name'));
        $chest->setLore(ExtensionManager::getModule(ModulesIdentifier::TRANSLATION_MANAGER)->getArrayTranslation('lobby-items-language-lore'));

        return [
            0 => $compass,
            1 => $skull,
            4 => $chest,
            8 => $star
        ];
    }
}