<?php

/*
 * This file is part of Strings
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/Strings
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\Strings;

use fab2s\Bom\Bom;
use fab2s\Utf8\Utf8;

/**
 * class Strings
 */
class Strings
{
    /**
     * The canonical EOL for normalization
     */
    const EOL = "\n";

    /**
     * The canonical encoding
     */
    const ENCODING = 'UTF-8';

    /**
     * U+200B zero width space
     * U+FEFF zero width no-break space
     */
    const ZERO_WIDTH_WS_CLASS = '\x{200B}\x{FEFF}';

    /**
     * U+00A0  no-break space
     * U+2000  en quad
     * U+2001  em quad
     * U+2002  en space
     * U+2003  em space
     * U+2004  three-per-em space
     * U+2005  four-per-em space
     * U+2006  six-per-em space
     * U+2007  figure space
     * U+2008  punctuation space
     * U+2009  thin space
     * U+200A  hair space
     * U+202F  narrow no-break space
     * U+3000  ideographic space
     */
    const NON_STANDARD_WS_CLASS = '\x{00A0}\x{2000}-\x{200A}\x{202F}\x{3000}';

    /**
     * normalize EOL to LF and strip null bit
     *
     * @param string $string
     *
     * @return string
     */
    public static function filter(string $string): string
    {
        /*
         * U+00 null bit
         * Zero width ws
         * normalized eol
         * normalized utf8
         */
        return Utf8::normalize(static::normalizeEol(preg_replace('`[\x{00}' . static::ZERO_WIDTH_WS_CLASS . ']+`u', '', $string)));
    }

    /**
     * @param string $string
     * @param bool   $normalize
     * @param bool   $includeTabs
     *
     * @return string
     */
    public static function singleWsIze(string $string, bool $normalize = false, bool $includeTabs = true): string
    {
        if ($normalize) {
            // multiple horizontal ws to a single low ws (eg ' ')
            return static::normalizeWs($string, $includeTabs);
        }

        return preg_replace('`(\h)(?:\1+)`u', '$1', $string);
    }

    /**
     * @param string $string
     *
     * @return string
     */
    public static function singleLineIze(string $string): string
    {
        return preg_replace("`\s*\R+`u", ' ', $string);
    }

    /**
     * @param $string string
     *
     * @return string
     */
    public static function dropZwWs(string $string): string
    {
        return preg_replace('`[' . static::ZERO_WIDTH_WS_CLASS . ']+`u', '', $string);
    }

    /**
     * @param string   $string
     * @param bool     $includeTabs    true to also replace tabs (\t) with ws ( )
     * @param int|null $maxConsecutive
     *
     * @return string
     */
    public static function normalizeWs(string $string, bool $includeTabs = true, ?int $maxConsecutive = null): string
    {
        // don't include regular ws unless we want to handle consecutive
        $extraWs = $includeTabs ? "\t" : '';
        $length  = '';
        $replace = ' ';
        if (isset($maxConsecutive)) {
            // as regular ws should be the majority, put it first
            $extraWs = " $extraWs";
            $length  = '{' . $maxConsecutive . ',}';
            $replace = str_repeat($replace, $maxConsecutive);
        }

        return preg_replace("`[$extraWs" . static::NON_STANDARD_WS_CLASS . "]$length`u", $replace, $string);
    }

    /**
     * @param string      $string
     * @param int|null    $maxConsecutive
     * @param string|null $eol
     *
     * @return string
     */
    public static function normalizeEol(string $string, ?int $maxConsecutive = null, string $eol = self::EOL): string
    {
        if ($maxConsecutive === null) {
            return preg_replace('`\s*?\R`u', $eol, $string);
        }

        if ($maxConsecutive === 1) {
            return preg_replace('`\s*\R`u', $eol, $string);
        }

        return preg_replace([
            // start with normalizing with LF (faster than CRLF)
            '`\s*?\R`u',
            // then remove high dupes
            "`\n{" . $maxConsecutive . ',}`u',
        ], [
            "\n",
            // restore EOL and set max consecutive
            str_repeat($eol, $maxConsecutive),
        ], $string);
    }

    /**
     * Normalizes a text document
     *
     * @param string $text
     *
     * @return string
     */
    public static function normalizeText(string $text): string
    {
        return trim(static::filter($text));
    }

    /**
     * Normalizes a title
     *
     * @param string $title
     *
     * @return string
     */
    public static function normalizeTitle(string $title): string
    {
        return Utf8::ucfirst(static::normalizeWs(static::singleLineIze(static::normalizeText($title)), true, 1));
    }

    /**
     * @param string $name
     *
     * @return string
     */
    public static function normalizeName(string $name): string
    {
        return Utf8::ucwords(static::normalizeTitle($name));
    }

    /**
     * wrapper for htmlspecialchars with utf-8 and ENT_COMPAT set as default
     *
     * @param string $string
     * @param int    $flag
     * @param bool   $hardEscape
     *
     * @return string
     */
    public static function escape(string $string, int $flag = ENT_COMPAT, bool $hardEscape = true)
    {
        return htmlspecialchars($string, $flag, static::ENCODING, (bool) $hardEscape);
    }

    /**
     * wrapper for htmlspecialchars with utf-8 and ENT_COMPAT set
     * which prevents double encoding
     *
     * @param string $string
     * @param int    $flag
     *
     * @return string
     */
    public static function softEscape(string $string, int $flag = ENT_COMPAT): string
    {
        return static::escape($string, $flag, false);
    }

    /**
     * wrapper for htmlspecialchars_decode with ENT_COMPAT set
     *
     * @param string $string
     * @param int    $quoteStyle
     *
     * @return string
     */
    public static function unEscape(string $string, int $quoteStyle = ENT_COMPAT): string
    {
        return htmlspecialchars_decode($string, $quoteStyle);
    }

    /**
     * @param string      $string
     * @param string|null $from
     * @param string      $to
     *
     * @return string
     */
    public static function convert(string $string, ?string $from = null, string $to = self::ENCODING): string
    {
        return mb_convert_encoding($string, $to, $from ? $from : static::detectEncoding($string));
    }

    /**
     * @param string $string
     *
     * @return string|null
     */
    public static function detectEncoding(string $string): ? string
    {
        if (Utf8::isUtf8($string)) {
            return static::ENCODING;
        }

        if ($bom = Bom::extract($string)) {
            return Bom::getBomEncoding($bom);
        }

        return mb_detect_encoding($string, 'ISO-8859-1,Windows-1252', true) ?: null;
    }

    /**
     * Truly constant time string comparison for Timing Attack protection
     *
     * Many implementations will stop after length comparison which can
     * leak length (not much I agree, but what topic is this?), or try to
     * be smart at failing to compare portion of the $reference which again
     * could leak $reference length
     *
     * This method just goes through exactly the same number of operations
     * in every cases
     *
     * @param string $userInput
     * @param string $reference
     *
     * @return bool
     */
    public static function secureCompare(string $userInput, string $reference): bool
    {
        if (strlen($userInput) !== strlen($reference)) {
            // preserve full comparison loop
            $comparison = $reference ^ $reference;
            // and return false
            $result = 1;
        } else {
            $comparison = $userInput ^ $reference;
            $result     = 0;
        }

        $len = strlen($comparison);
        for ($i = $len - 1; $i >= 0; --$i) {
            $result |= ord($comparison[$i]);
        }

        return !$result;
    }

    /**
     * Generate a pretty reliable hash to identify strings
     * Adding the length reduces collisions by quite a lot
     *
     * @param string $content
     *
     * @return string
     */
    public static function contentHash(string $content): string
    {
        return strlen($content) . '_' . hash('sha256', $content);
    }
}
