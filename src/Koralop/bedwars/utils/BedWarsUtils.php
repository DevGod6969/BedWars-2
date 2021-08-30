<?php

namespace Koralop\bedwars\utils;

use addon\FormAPI\CustomForm;
use Koralop\bedwars\BedWarsLoader;
use Koralop\bedwars\BedWarsPlayer;
use Koralop\bedwars\lang\TranslateManager;
use pocketmine\utils\TextFormat;

/**
 * Class BedWarsUtils
 * @package Koralop\bedwars\utils
 */
class BedWarsUtils
{

    /** @var string[] */
    public const TEAMS = [
        'red' => ['&c', 'R'],
        'blue' => ['&1', 'B'],
        'green' => ['&a', 'G'],
        'yellow' => ['&e', 'Y'],
    ];

    public const WOOL_COLOR = [
        '§a' => 5,
        '§c' => 14,
        '§e' => 4,
        '§6' => 1,
        '§f' => 0,
        '§b' => 3,
        '§1' => 11
    ];

    /**
     * @param BedWarsPlayer $player
     */
    public static function sendBedWarsCreate(BedWarsPlayer $player): void
    {
        $form = new CustomForm(function (BedWarsPlayer $player, $data = null): bool {

            if ($data == null)
                return false;

            $player->getSession()->createArena['level'] = $player->getLevel();
            $player->getSession()->createArena['name'] = $player->getLevel()->getFolderName();
            $player->getSession()->createArena['playerPerTeam'] = $data[0];

            BedWarsLoader::getInstance()->getGameManager()->addGame($player->getSession()->createArena);

            $player->sendMessage(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('finish.place', $player->getSession()->getLang())));
            return true;
        });

        $form->setTitle(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('form.create.arena.title', $player->getSession()->getLang())));
        $form->addSlider('Players Per Team', 1, 4);

        $player->sendForm($form);
    }

    /**
     * @param BedWarsPlayer $player
     */
    public static function sendOptionForm(BedWarsPlayer $player): void
    {
        $form = new CustomForm(function (BedWarsPlayer $player, $data = null): bool {

            if ($data == null)
                return false;

            $lang = $data[0];

            if ($data[0] != BedWarsLoader::getInstance()->getTranslateManager()->getIdByLang($player->getSession()->getLang()))
                $player->getSession()->setLang(BedWarsLoader::getInstance()->getTranslateManager()->getLangById($lang));

            $player->spawn();
            return true;
        });

        $form->setTitle(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('form.settings.title', $player->getSession()->getLang())));
        $form->addDropdown(TextFormat::colorize(BedWarsLoader::getInstance()->getTranslateManager()->getTranslation('form.settings.lang', $player->getSession()->getLang())), ['English', 'Español'], BedWarsLoader::getInstance()->getTranslateManager()->getIdByLang($player->getSession()->getLang()));

        $player->sendForm($form);
    }

    /**
     * @param $n
     * @return string
     */
    public static function rome($n): string
    {
        $c = 'IVXLCDM';
        for ($a = 5, $b = $s = ''; $N; $b++, $a ^= 7)//todo add 2 sector
            for ($o = $N % $a, $N = $N / $a ^ 0; $o--; $s = @$c[$o > 2 ? $b + $N - ($N &= -2) + $o = 1 : $b] . $s) ;
        return $s;
    }
}