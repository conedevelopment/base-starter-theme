<?php

namespace Base\Support;

abstract class Str
{
    /**
     * Remove the empty paragraphs.
     */
    public static function removeEmptyP(string $content): string
    {
        $content = force_balance_tags($content);

        return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
    }

    /**
    * Return the slug of a string to be used in a URL.
    *
    * @return string
    */
    public static function slugify($text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
