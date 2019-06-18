<?php

namespace TextParser\Util;

final class StringUtis
{
    /**
     * Return just the number in a string
     * @param string $url
     * @return string
     */
    public static function onlyNumbers($str)
    {
        return preg_replace('/\D/', '', $str);
    }

    /**
     * Remove especial chars
     *
     * @param string $string
     * @return string
     */
    public static function removeSpecialChars(string $string): string
    {
        return preg_replace(
            [
                "/(á|à|ã|â|ä|Á|À|Ã|Â|Ä)/i",
                "/(é|è|ê|ë|É|È|Ê|Ë)/",
                "/(í|ì|î|ï|Í|Ì|Î|Ï)/",
                "/(ó|ò|õ|ô|ö|Ó|Ò|Õ|Ô|Ö)/",
                "/(ú|ù|û|ü|Ú|Ù|Û|Ü)/",
                "/(ñ|Ñ)/",
                "/(ç|Ç)/",
                "/(ý|ÿ|Ý)/",
                "/[^a-z0-9 ]/i"
            ],
            ['a', 'e', 'i', 'o', 'u', 'n', 'c', 'y', ''],
            $string
        );
    }
}
