<?php

/*
 * This file is part of Strings
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/Strings
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\Strings\Tests;

use fab2s\Strings\Strings;

/**
 * Class StringsTest
 */
class StringsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider filterData
     *
     * @param string $input
     * @param string $expected
     */
    public function testFilter(string $input, string $expected)
    {
        $this->assertSame($expected, Strings::filter($input));
    }

    /**
     * @dataProvider singleWsIzeData
     *
     * @param string $input
     * @param string $expected
     */
    public function testSingleWsIze(string $input, string $expected)
    {
        $this->assertSame($expected, Strings::singleWsIze($input));
    }

    /**
     * @dataProvider singleLineIzeData
     *
     * @param string $input
     * @param string $expected
     */
    public function testSingleLineIze(string $input, string $expected)
    {
        $this->assertSame($expected, Strings::singleLineIze($input));
    }

    /**
     * @dataProvider normalizeTitleData
     *
     * @param string $input
     * @param string $expected
     */
    public function testNormalizeTitle(string $input, string $expected)
    {
        $this->assertSame($expected, Strings::normalizeTitle($input));
    }

    /**
     * @dataProvider normalizeNameData
     *
     * @param string $input
     * @param string $expected
     */
    public function testNormalizeName(string $input, string $expected)
    {
        $this->assertSame($expected, Strings::normalizeName($input));
    }

    /**
     * @dataProvider normalizeWsData
     *
     * @param string   $input
     * @param bool     $includeTabs
     * @param int|null $maxConsecutive
     * @param string   $expected
     */
    public function testNormalizeWs(string $input, bool $includeTabs, ?int $maxConsecutive, string $expected)
    {
        $this->assertSame($expected, Strings::normalizeWs($input, $includeTabs, $maxConsecutive));
    }

    /**
     * @dataProvider normalizeEolData
     *
     * @param string   $input
     * @param int|null $maxConsecutive
     * @param string   $eol
     * @param string   $expected
     */
    public function testNormalizeEol(string $input, ?int $maxConsecutive, string $eol, string $expected)
    {
        $this->assertSame($expected, Strings::normalizeEol($input, $maxConsecutive, $eol));
    }

    /**
     * @return array
     */
    public function normalizeNameData(): array
    {
        return [
            [
                'input'          => "this is\r\r\n   one " . json_decode('"\u000B"') . 'text',
                'expected'       => 'This Is One Text',
            ],
        ];
    }

    /**
     * @return array
     */
    public function normalizeTitleData(): array
    {
        return [
            [
                'input'          => "this is\r\r\none text \n\f\nwith \n\n\n tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'expected'       => "This is one text with tons of ws and LF's every where",
            ],
        ];
    }

    /**
     * @return array
     */
    public function singleLineIzeData(): array
    {
        return [
            [
                'input'          => "this is\r\r\none text \n\f\nwith \n\n\n tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'expected'       => "this is one text with  tons of ws \tand LF's every where",
            ],
            [
                'input'          => "this is\r\r\none more text \n\f\nwith \n
                \n
                \r\n
                \n tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'expected'       => "this is one more text with  tons of ws \tand LF's every where",
            ],
        ];
    }

    /**
     * @return array
     */
    public function normalizeEolData(): array
    {
        return [
            [
                'input'          => "this is\r\r\none text \n \f \n \n with" . json_decode('"\u2028"') . json_decode('"\u2029"') . "tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'maxConsecutive' => null,
                'eol'            => "\n",
                'expected'       => "this is\n\none text\n\n\n\n with\n\ntons of ws\n\tand LF's\nevery\nwhere",
            ],
            [
                'input'          => "this is\r\r\none eol text \n  \f \n \n with" . json_decode('"\u2028"') . json_decode('"\u2029"') . "tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'maxConsecutive' => 1,
                'eol'            => "\n",
                'expected'       => "this is\none eol text\n with\ntons of ws\n\tand LF's\nevery\nwhere",
            ],
            [
                'input'          => "this is\r\r\n\rone text \n \f \n  \n with" . json_decode('"\u2028"') . json_decode('"\u2029"') . "tons of ws \f\tand LF's \r\nevery" . json_decode('"\u000B"') . 'where',
                'maxConsecutive' => 2,
                'eol'            => "\n",
                'expected'       => "this is\n\none text\n\n with\n\ntons of ws\n\tand LF's\nevery\nwhere",
            ],
        ];
    }

    /**
     * @return array
     */
    public function normalizeWsData(): array
    {
        return [
            [
                'input'          => "this is                     one   text \nwith " . json_decode('"\u2009"') . json_decode('"\u2008"') . json_decode('"\u200A"') . "tons of ws \t\tand LF's \r\neverywhere",
                'includeTabs'    => true,
                'maxConsecutive' => 1,
                'expected'       => "this is one text \nwith tons of ws and LF's \r\neverywhere",
            ],
            [
                'input'          => "   this is                     one   text \nwith " . json_decode('"\u2009"') . json_decode('"\u2008"') . json_decode('"\u200A"') . "tons of ws \t\tand LF's \r\neverywhere     ",
                'includeTabs'    => true,
                'maxConsecutive' => 1,
                'expected'       => " this is one text \nwith tons of ws and LF's \r\neverywhere ",
            ],
            [
                'input'          => "this is     one more   text \nwith tons of ws \t\tand LF's \r\neverywhere",
                'includeTabs'    => false,
                'maxConsecutive' => 1,
                'expected'       => "this is one more text \nwith tons of ws \t\tand LF's \r\neverywhere",
            ],
            [
                'input'          => "this is     another   text \nwith " . json_decode('"\u2009"') . json_decode('"\u2009"') . "tons of ws \t\tand LF's \r\neverywhere",
                'includeTabs'    => false,
                'maxConsecutive' => 2,
                'expected'       => "this is  another  text \nwith  tons of ws \t\tand LF's \r\neverywhere",
            ],
        ];
    }

    /**
     * @return array
     */
    public function singleWsIzeData(): array
    {
        return [
            // input, expected
            [
                'input'    => "this is   a   text \nwith tons of ws \t\tand LF's \r\neverywhere",
                'expected' => "this is a text \nwith tons of ws \tand LF's \r\neverywhere",
            ],
            [
                'input'    => "   this is   a      text \nwith tons of ws \t\tand LF's \r\neverywhere   ",
                'expected' => " this is a text \nwith tons of ws \tand LF's \r\neverywhere ",
            ],
            [
                'input'    => "this is a   text \f\nwith" . json_decode('"\u2009"') . json_decode('"\u2009"') . "tons of ws \t  \tand LF's \r\neverywhere",
                'expected' => "this is a text \f\nwith" . json_decode('"\u2009"') . "tons of ws \t \tand LF's \r\neverywhere",
            ],
        ];
    }

    /**
     * @return array
     */
    public function filterData(): array
    {
        return [
            // input, expected
            ["this is a \x00text \n\nwith \rws \t\tand LF's \r\neverywh\0ere", "this is a text\n\nwith\nws \t\tand LF's\neverywhere"],
            ["this is another text \0\nwith \r\rws \t\tand LF's \r\neverywhere", "this is another text\nwith\n\nws \t\tand LF's\neverywhere"],
            ['this is yet an' . json_decode('"\uFEFF"') . "other text \0\nwith \n\rws \t\tand LF's \r\nevery" . json_decode('"\u200B"') . 'where', "this is yet another text\nwith\n\nws \t\tand LF's\neverywhere"],
        ];
    }
}
