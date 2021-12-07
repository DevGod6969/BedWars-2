<?php

namespace bedwars\utils;

final class URL
{

    /**
     * @param string $url
     * @return bool
     */
    public static function isValid(string $url): bool
    {
        $url = filter_var($url, FILTER_SANITIZE_URL);

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return true;
        } else {
            return false;
        }
    }
}