# Strings

[![Build Status](https://travis-ci.com/fab2s/Strings.svg?branch=master)](https://travis-ci.com/fab2s/Strings) [![Total Downloads](https://poser.pugx.org/fab2s/strings/downloads)](//packagist.org/packages/fab2s/strings) [![Monthly Downloads](https://poser.pugx.org/fab2s/strings/d/monthly)](//packagist.org/packages/fab2s/strings) [![Latest Stable Version](https://poser.pugx.org/fab2s/strings/v/stable)](https://packagist.org/packages/fab2s/strings) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/fab2s/strings/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/fab2s/Strings/?branch=master) [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat)](http://makeapullrequest.com) [![License](https://poser.pugx.org/fab2s/strings/license)](https://packagist.org/packages/fab2s/strings)

A purely static String Helper to handle more advanced utf8 string manipulations

## Installation

`Strings` can be installed using composer:

```
composer require "fab2s/strings"
```

`Strings` is also included in [OpinHelper](https://github.com/fab2s/OpinHelpers) which packages several bellow "Swiss Army Knife" level Helpers covering some of the most annoying aspects of php programing, such as UTF8 string manipulation, high precision Mathematics or properly locking a file

Should you need to work with php bellow 7.1, you can still use [OpinHelper](https://github.com/fab2s/OpinHelpers) `0.x`

## Prerequisites

As it requires `Utf8`, `Strings` requires [mb_string](https://php.net/mb_string), [ext-intl](https://php.net/intl) is auto detected and used when available for UTF-8 Normalization

## In practice

`Strings` implement some basic text manipulation function that can be pretty useful IRL


- `filter(string $string):string` 

    Drops Zero Width white chars, normalizes EOL and Normalize UTF8 if [ext-intl](https://php.net/intl) is available

- `singleWsIze(string $string, bool $normalize = false, bool $includeTabs = true):string` 

    Replace repeated white-spaces to a single one, preserve original white-spaces unless normalized (every white-spaces to ' '), with or without tabs (\t)

- `singleLineIze(string $string):string` 

    Make string fit in one line by replacing EOLs and white-spaces to normalized single white-spaces

- `dropZwWs(string $string):string` 

    Remove Zero Width white-spaces 

- `normalizeWs(string $string, bool $includeTabs = true, int $maxConsecutive = null):string` 

    Normalize white-spaces to a single ` ` by default, include tabs by default

- `normalizeEol($string, $maxConsecutive = null, $eol = self::EOL):string` 

    Normalize EOLs to a single LF by default

- `normalizeText(string $text):string` 

    Return `trim`'d and `filter`'d $text 

- `normalizeTitle(string $title):string` 

    Return `singleLineIze`'d, `normalizeWs`'d, `normalizeText`'d and `ucfirst`'d $title (`" the best ever \t\r\n article"` -> `"The best ever article"`) 

- `normalizeName(string $name):string` 

    Return `ucword`'d and `normalizeTitle`'d $name (`"john \n\t doe  "` -> `"John Doe"`) 

- `escape(string $string, int $flag = ENT_COMPAT, bool $hardEscape = true):string` 

    [htmlspecialchars()](https://php.net/htmlspecialchars) wrapper with UTF8 set as encoding

- `softEscape(string $string, int $flag = ENT_COMPAT):string` 

    Shortcut for `escape(string $string, $flag, true)`

- `unEscape(string $string, int $quoteStyle = ENT_COMPAT):string` 

    [htmlspecialchars_decode()](https://php.net/htmlspecialchars_decode) wrapper 

- `convert(string $string, string $from = null, string $to = self::ENCODING):string` 

    Convert encoding to UTF8 by default. Basic $from encoding detection using `Strings::detectEncoding()`

- `detectEncoding(string $string):string|null` 

    Detect encoding by checking `Utf8::isUf8()`, then trying with BOMs and ultimately fall back to [mb_detect_encoding()](https://php.net/mb_detect_encoding) with limited charsets first, then more internally in [mb_convert_encoding()](https://php.net/mb_convert_encoding) 

- `secureCompare(string $test, string $reference):bool` 

    Perform a [Timing Attack](https://en.wikipedia.org/wiki/Timing_attack) safe string comparison (Truly constant operations comparison)

- `contentHash(string $content):string` 

    Return a `sha256` hash of the $content prefixed with $content length. Indented to quickly and reliably detect $content updates.

## Requirements

`Strings` is tested against php 7.2, 7.3, 7.4 and 8.0

## Contributing

Contributions are welcome, do not hesitate to open issues and submit pull requests.

## License

`Strings` is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT)