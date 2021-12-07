<?php

namespace bedwars\api\xp;

final class XP
{

    /** @var array */
    public static array $xp = [];
    /** @var int */
    public static int $maxLevels = 100;
    /** @var float */
    public static float $requiredXpPerLevel = 1.5;
    /** @var array */
    public static array $level = [];
    /** @var int */
    public static int $firstLevelXpRequired = 10;

    /**
     * @param string $playerName
     * @param int $xp
     * @return void
     */
    public static function add(string $playerName, int $xp): void
    {
        self::set($playerName, self::get($playerName) + $xp);
    }

    /**
     * @param string $playerName
     * @return int
     */
    public static function get(string $playerName): int
    {
        if (!isset(self::$xp[$playerName]))
            self::set($playerName, 0);

        return self::$xp[$playerName];
    }

    /**
     * @param string $playerName
     * @param int $xp
     * @return void
     */
    public static function set(string $playerName, int $xp): void
    {
        self::$xp[$playerName] = $xp;
        self::checkLevel($playerName);
    }

    /**
     * @param string $playerName
     * @param int $xp
     * @return void
     */
    public static function reduce(string $playerName, int $xp): void
    {
        self::set($playerName, self::get($playerName) - $xp);
    }

    /**
     * @param string $playerName
     * @return int
     */
    public static function checkLevel(string $playerName): int
    {
        if (!isset(self::$level[$playerName]))
            self::$level[$playerName] = 1;

        if (self::get($playerName) >= self::getXpRequiredForLevel(self::$level[$playerName])) {
            self::$level[$playerName] = self::$level[$playerName] + 1;
        }

        return self::$level[$playerName];
    }

    /**
     * @param int $level
     * @return int
     */
    public static function getXpRequiredForLevel(int $level): int
    {
        $xpRequired = self::$firstLevelXpRequired;
        $i = 1;
        for (; ;) {
            if ($i == $level) {
                return (int)$xpRequired;
            }

            $xpRequired = $xpRequired * self::$requiredXpPerLevel;
            $i++;
        }
    }

    /**
     * @param string $playerName
     * @return string
     */
    public static function getBarXP(string $playerName): string
    {
        $currentXp = self::get($playerName);
        $requiredXp = self::getXpRequiredForLevel(self::$level[$playerName]);
        $percent = round(($currentXp / $requiredXp) * 100, 1);
        $text = '&8[';

        for ($i = 0; ; $i++) {
            if ($i == 10) {
                $text .= '&8]';
                return $text;
            }

            if ($percent > (10 * $i)) {
                $text .= '&a▬';
            } else {
                $text .= '&7▬';
            }
        }
    }
}