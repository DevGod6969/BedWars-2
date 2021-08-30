<?php

namespace addon;

use pocketmine\math\Vector3;

/**
 * Class lVector3
 * @package addon
 */
class lVector3 extends Vector3
{

    /**
     * @param string $delimeter
     * @param Vector3 $vector
     * @param float $yaw
     * @param float $pitch
     * @return string
     */
    public static function vectorToString(string $delimeter, Vector3 $vector, $yaw = 0.0, $pitch = 0.0): string
    {
        $array = [(float)$vector->getX(), (float)$vector->getY(), (float)$vector->getZ()];
        if ($yaw > 0 && $pitch > 0) {
            $array[] = $yaw;
            $array[] = $pitch;
        }
        $string = "";
        foreach ($array as $splitValue) {
            $string .= $splitValue . ":";
        }
        return $string;
    }

    /**
     * @param string $delimeter
     * @param string $string
     * @param float $yaw
     * @param float $pitch
     * @return Vector3
     */
    public static function stringToVector(string $delimeter, string $string, &$yaw = 0.0, &$pitch = 0.0): Vector3
    {
        $split = explode($delimeter, $string);
        if (isset($split[3]) && isset($split[4])) {
            $yaw = floatval($split[3]);
            $pitch = floatval($split[4]);
        }
        return new Vector3(floatval($split[0]), floatval($split[1]), floatval($split[2]));
    }
}