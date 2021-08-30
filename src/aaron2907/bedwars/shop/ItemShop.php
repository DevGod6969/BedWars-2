<?php


namespace aaron2907\bedwars\shop;

use aaron2907\bedwars\BedWarsLoader;
use aaron2907\bedwars\BedWarsPlayer;
use aaron2907\bedwars\utils\BedWarsUtils;
use pocketmine\item\Armor;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\network\mcpe\protocol\ModalFormRequestPacket;
use pocketmine\utils\TextFormat;

/**
 * Class ItemShop
 * @package aaron2907\bedwars\shop
 */
class ItemShop
{

    const PURCHASE_TYPE_IRON = 0;
    const PURCHASE_TYPE_GOLD = 1;
    const PURCHASE_TYPE_EMERALD = 2;
    const PURCHASE_TYPE_DIAMOND = 3;

    /**
     * @var array $shopWindows
     */
    public static $shopWindows = [
        1 => ['name' => '§l§aArmor'],
        2 => ['name' => '§l§aWeapons'],
        3 => ['name' => '§l§aBlocks'],
        4 => ['name' => '§l§aBows'],
        5 => ['name' => '§l§aPotions'],
        6 => ['name' => '§l§aSpecials']
    ];

    /**
     * @var array $shopPages
     */
    public static $shopPages = [
        0 => ['§6Chainmal Armor\n§l§e40 IRON' => ['image' => 'textures/items/chainmail_chestplate'],
            '§6Iron Armor\n§l§e12 GOLD' => ['image' => ''],
            '§6Diamond Armor\n§l§e6 EMERALD' => ['image' => 'textures/items/diamond_chestplate']],
        1 => ['§6Stone Sword\n§l§e10 IRON' => ['image' => ''],
            '§6Iron Sword\n§l§e7 GOLD' => ['image' => 'textures/items/iron_sword'],
            '§6Diamond Sword\n§l§e7 EMERALD' => ['image' => ''],
            '§6Diamond pick\n§l§e7 DIAMOND' => ['image' => ''],
            '§6Diamond ax\n§l§e7 DIAMOND' => ['image' => ''],
            '§6Knockback Stick\n§l§e2 EMERALD' => ['image' => '']],
        2 => ['§6Wool 16x\n§l§e4 IRON' => ['image' => ''],
            '§6Sandstone 16x\n§l§e12 IRON' => ['image' => ''],
            '§6Endstone 12x\n§l§e24 IRON' => ['image' => ''],
            '§6Ladder 16x\n§l§e4 IRON' => ['image' => ''],
            '§6Oak Wood 16x\n§l§e4 GOLD' => ['image' => ''],
            '§6Obsidian 4x\n§l§e4 EMERALD' => ['image' => '']],
        3 => ['§6Normal Bow\n§l§e12 GOLD' => ['image' => ''],
            '§6Bow §b(Power 1)\n§l§e24 GOLD' => ['image' => ''],
            '§6Bow §b(Power 1, Punch 1)\n§l§e6 EMERALD' => ['image' => '']],
        4 => ['§6Speed II Potion (45 sec.)\n§l§e1 EMERALD' => ['image' => ''],
            '§6Jump V Potion (45 sec.)\n§l§e1 EMERALD' => ['image' => ''],
            '§6Invisibility Potion (30 sec.)\n§l§e1 EMERALD' => ['image' => '']],
        5 => ['§6Golden Apple\n§l§e3 GOLD' => ['image' => ''],
            '§6Carne 5x\n§l§e10 IRON' => ['image' => ''],
            '§6SNOWBALL 16x\n§l§e40 IRON' => ['image' => ''],
            '§6FLECHAS 5x\n§l§e8 IRON' => ['image' => ''],
            '§6Enderpearl 1x\n§l§e4 EMERALD' => ['image' => ''],
            '§6Water Bucker\n§l§e1 EMERALD' => ['image' => ''],
            '§6Egg 16x\n§l§e4 EMERALD' => ['image' => ''], '§6TNT\n§l§e8 GOLD' => ['image' => ''],
        ],
    ];

    /**
     * @var array $itemData
     */
    public static $itemData = [
        0 => [0 => ['name' => 'Chainmal Armor', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 0, 'price' => 40, 'item' => ['id' => Item::CHAIN_LEGGINGS, 'damage' => 0]],
            1 => ['name' => 'Iron Armor', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 0, 'price' => 12, 'item' => ['id' => Item::IRON_LEGGINGS, 'damage' => 0]],
            2 => ['name' => 'Diamond Armor ', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 0, 'price' => 6, 'item' => ['id' => ITEM::DIAMOND_LEGGINGS, 'damage' => 0]]
        ],
        1 => [0 => ['name' => 'Stone Sword', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 1, 'price' => 10, 'item' => ['id' => Item::STONE_SWORD, 'damage' => 0]],
            1 => ['name' => 'Iron Sword', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 1, 'price' => 7, 'item' => ['id' => Item::IRON_SWORD, 'damage' => 0]],
            2 => ['name' => 'Diamond Sword', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 7, 'item' => ['id' => Item::DIAMOND_SWORD, 'damage' => 0]],
            3 => ['name' => '§6Diamond pick', 'type' => self::PURCHASE_TYPE_DIAMOND, 'amount' => 1, 'price' => 4, 'item' => ['id' => 278, 'damage' => 0]],
            4 => ['name' => '§6Diamond ax', 'type' => self::PURCHASE_TYPE_DIAMOND, 'amount' => 1, 'price' => 4, 'item' => ['id' => 279, 'damage' => 0]],
            5 => ['name' => 'Knockback Stick', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 2, 'item' => ['id' => Item::STICK, 'damage' => 0]]
        ],
        2 => [0 => ['name' => 'Wool 16x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 16, 'price' => 4, 'item' => ['id' => Item::WOOL, 'damage' => 'depend']],
            1 => ['name' => 'Sandstone 16x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 16, 'price' => 12, 'item' => ['id' => Item::SANDSTONE, 'damage' => 0]],
            2 => ['name' => 'Endstone 12x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 12, 'price' => 24, 'item' => ['id' => Item::END_STONE, 'damage' => 0]],
            3 => ['name' => 'Ladder 16x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 16, 'price' => 4, 'item' => ['id' => Item::LADDER, 'damage' => 0]],
            4 => ['name' => 'Oak Wood 16x', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 16, 'price' => 4, 'item' => ['id' => 5, 'damage' => 0]],
            5 => ['name' => 'Obsidian 4x', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 4, 'price' => 4, 'item' => ['id' => Item::OBSIDIAN, 'damage' => 0]]
        ],
        3 => [0 => ['name' => 'Bow 1', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 1, 'price' => 12, 'item' => ['id' => Item::BOW, 'damage' => 0]],
            1 => ['name' => 'Bow 2', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 1, 'price' => 24, 'item' => ['id' => Item::BOW, 'damage' => 0]],
            2 => ['name' => 'Bow 3', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 6, 'item' => ['id' => Item::BOW, 'damage' => 0]]
        ],
        4 => [0 => ['name' => 'Potion of Speed', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 1, 'item' => ['id' => 438, 'damage' => 0]],
            1 => ['name' => 'Jump Potion', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 1, 'item' => ['id' => 438, 'damage' => 0]],
            2 => ['name' => 'Invisibility Potion', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 1, 'item' => ['id' => 438, 'damage' => 0]]
        ],
        5 => [0 => ['name' => 'Golden Apple', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 1, 'price' => 3, 'item' => ['id' => Item::GOLDEN_APPLE, 'damage' => 0]],
            1 => ['name' => 'Carne 5x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 5, 'price' => 10, 'item' => ['id' => 364, 'damage' => 0]],
            2 => ['name' => 'SNOWBALL 16x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 16, 'price' => 40, 'item' => ['id' => Item::SNOWBALL, 'damage' => 0]],
            3 => ['name' => 'FLECHAS 5x', 'type' => self::PURCHASE_TYPE_IRON, 'amount' => 5, 'price' => 8, 'item' => ['id' => Item::ARROW, 'damage' => 0]],
            4 => ['name' => 'Enderpearl 1x', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 4, 'item' => ['id' => Item::ENDER_PEARL, 'damage' => 0]],
            5 => ['name' => 'Water Bucket', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 1, 'price' => 1, 'item' => ['id' => 325, 'damage' => 0]],
            6 => ['name' => 'Egg 16x', 'type' => self::PURCHASE_TYPE_EMERALD, 'amount' => 16, 'price' => 4, 'item' => ['id' => Item::EGG, 'damage' => 0]],
            7 => ['name' => 'TNT', 'type' => self::PURCHASE_TYPE_GOLD, 'amount' => 1, 'price' => 8, 'item' => ['id' => Item::TNT, 'damage' => 0]],
        ]
    ];

    /**
     * @param int $category
     * @return mixed
     */
    public static function getCategory(int $category)
    {
        return self::$shopWindows[$category];
    }

    /**
     * @param int $id
     * @param $data
     * @param BedWarsPlayer $player
     * @param int $lastPage
     */
    public static function handleTransaction(int $id, $data, BedWarsPlayer $player, int $lastPage)
    {
        if (is_null($data))
            return;

        $itemData = self::$itemData[$id][$data];
        $amount = $itemData['amount'];
        $price = $itemData['price'];
        $id = $itemData['item']['id'];
        $damage = (int)$itemData['item']['damage'];
        $player->sendMessage($itemData['amount'] . ' & ' . $itemData['price']);
        $check = '';
        $type = $itemData['type'];
        $typeString = '';
        $removeItem = null;
        switch ($type) {
            case self::PURCHASE_TYPE_IRON;
                $typeString = 'iron';
                $removeItem = Item::get(Item::IRON_INGOT, 0, $price);
                $check = $player->getInventory()->contains(Item::get(Item::IRON_INGOT, $damage, $price));
                break;
            case self::PURCHASE_TYPE_GOLD;
                $typeString = 'gold';
                $removeItem = Item::get(Item::GOLD_INGOT, 0, $price);
                $check = $player->getInventory()->contains(Item::get(Item::GOLD_INGOT, $damage, $price));
                break;
            case self::PURCHASE_TYPE_EMERALD;
                $typeString = 'emerald';
                $removeItem = Item::get(Item::EMERALD, 0, $price);
                $check = $player->getInventory()->contains(Item::get(Item::EMERALD, $damage, $price));
                break;
            case self::PURCHASE_TYPE_DIAMOND;
                $typeString = 'diamond';
                $removeItem = Item::get(Item::DIAMOND, 0, $price);
                $check = $player->getInventory()->contains(Item::get(Item::DIAMOND, $damage, $price));
                break;
        }

        if (!$check) {
            $player->sendMessage(TextFormat::colorize(str_replace('{item}', strtolower(ucfirst($typeString)), BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('no.item', $player->getSession()->getLang()))));
            return;
        }

        $playerlayerTeam = $player->getSession()->getTeam();
        if ($playerlayerTeam == null) return;


        if ($id == Item::WOOL) {
            $damage = BedWarsUtils::WOOL_COLOR[$playerlayerTeam->getColor()];
        } elseif (Item::get($id) instanceof Armor) {
            self::handleArmorTransaction($data, $player);
            return;
        }
        $item = Item::get($id, $damage, $amount);
        $wasPurchased = false;

        foreach ($player->getInventory()->getContents() as $index => $content) {
            if (self::isSword($content->getId()) && self::isSword($id)) {
                $wasPurchased = true;
                if ($id !== $content->getId()) {
                    $player->getInventory()->removeItem($content);
                    $player->getInventory()->setItem($index, $item);
                } else {
                    $player->sendMessage(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('already.sword', $player->getSession()->getLang())));
                    return;
                }
            }
        }
        $player->sendMessage(TextFormat::colorize(str_replace(['{objet}', '{price}', '{item}'], [$itemData['name'], $price, ucfirst($typeString)], BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('sucesfully.purchase', $player->getSession()->getLang()))));
        self::sendPage($player, $lastPage);

        if ($wasPurchased)
            return;


        if ($id == Item::BOW)
            self::handleBowTransaction($data, $item);


        $player->getInventory()->removeItem($removeItem);
        $player->getInventory()->addItem($item);
    }

    /**
     * @param int $data
     * @param BedWarsPlayer $player
     */
    public static function handleArmorTransaction(int $data, BedWarsPlayer $player)
    {
        $data = intval($data);
        $boots = '';
        $leggings = '';
        $helmet = '';
        $chestplate = '';
        switch ($data) {
            case 0;
                $boots = Item::get(Item::CHAIN_BOOTS, 0, 1);
                $leggings = Item::get(Item::CHAIN_LEGGINGS, 0, 1);
                $helmet = Item::get(Item::CHAIN_HELMET, 0, 1);
                $chestplate = Item::get(Item::CHAIN_CHESTPLATE, 0, 1);
                break;
            case 1;
                $boots = Item::get(Item::IRON_BOOTS);
                $leggings = Item::get(Item::IRON_LEGGINGS);
                $helmet = Item::get(Item::IRON_HELMET);
                $chestplate = Item::get(Item::IRON_CHESTPLATE);
                break;
            case 2;
                $boots = Item::get(Item::DIAMOND_BOOTS);
                $leggings = Item::get(Item::DIAMOND_LEGGINGS);
                $helmet = Item::get(Item::DIAMOND_HELMET);
                $chestplate = Item::get(Item::DIAMOND_CHESTPLATE);
        }
        $player->getArmorInventory()->setBoots($boots);
        $player->getArmorInventory()->setLeggings($leggings);
        $player->getArmorInventory()->setHelmet($helmet);
        $player->getArmorInventory()->setChestplate($chestplate);
    }

    /**
     * @param int $itemId
     * @return bool
     */
    public static function isSword(int $itemId)
    {
        $swords = [Item::IRON_SWORD, Item::STONE_SWORD, Item::WOODEN_SWORD, Item::DIAMOND_SWORD];
        if (in_array($itemId, $swords)) {
            return true;
        }
        return false;
    }

    /**
     * @param int $data
     * @param Item $item
     */
    public static function handleBowTransaction(int $data, Item $item)
    {
        switch ($data) {
            case 1;
                $enchantment = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::POWER), 1);
                $item->addEnchantment($enchantment);
                break;
            case 2;
                $enchantment = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::POWER), 1);
                $enchantment1 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PUNCH), 1);
                foreach ([$enchantment, $enchantment1] as $eIns) {
                    $item->addEnchantment($eIns);
                }
        }
    }

    /**
     * @param int $itemId
     * @return bool
     */
    public static function isArmor(int $itemId)
    {
        $armors = [Item::CHAIN_BOOTS, Item::CHAIN_LEGGINGS, Item::CHAIN_HELMET, Item::CHAIN_CHESTPLATE, Item::IRON_BOOTS, Item::IRON_LEGGINGS, Item::IRON_HELMET, Item::IRON_CHESTPLATE, Item::DIAMOND_BOOTS, Item::DIAMOND_LEGGINGS, Item::DIAMOND_HELMET, Item::DIAMOND_CHESTPLATE];
        if (in_array($itemId, $armors)) {
            return true;
        }
        return false;
    }

    /**
     * @param BedWarsPlayer $player
     */
    public static function sendDefaultShop(BedWarsPlayer $player)
    {
        $data['title'] = 'Item Shop';
        $data['type'] = 'form';
        $data['content'] = '';
        foreach (self::$shopWindows as $windows) {
            $button = ['text' => $windows['name']];

            $data['buttons'][] = $button;
        }

        $playeracket = new ModalFormRequestPacket();
        $playeracket->formId = 50;
        $playeracket->formData = json_encode($data);
        $player->dataPacket($playeracket);

    }


    /**
     * @param BedWarsPlayer $player
     * @param int $playerage
     */
    public static function sendPage(BedWarsPlayer $player, int $playerage)
    {
        $formId = $playerage;
        $data['title'] = 'Page ' . $playerage;
        $data['type'] = 'form';
        $playerage = self::$shopPages[$playerage];
        $data['content'] = '';
        foreach ($playerage as $itemsToBuy => $key) {
            $string = strval($itemsToBuy);
            $button = ['text' => $string];
            if (!empty($key['image'])) {
                $button['image']['type'] = 'path';
                $button['image']['data'] = $key['image'];
            }
            $data['buttons'][] = $button;
        }

        $playeracket = new ModalFormRequestPacket();
        $playeracket->formId = $formId;
        $playeracket->formData = json_encode($data);
        $player->dataPacket($playeracket);

    }
}