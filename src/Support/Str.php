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
        return sanitize_title($text);
    }
}
