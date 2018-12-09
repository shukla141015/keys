<?php

use App\Keys\PageNumbers\BitcoinPageNumber;
use App\Keys\PageNumbers\EthereumPageNumber;
use App\Support\Enums\CoinType;

function increment_string(string $number)
{
    if (! preg_match('/^\d+$/', $number)) {
        throw new RuntimeException('The string should be fully numeric');
    }

    $carry = 1;

    $numbers = str_split($number);

    for ($i = count($numbers) - 1; $i >= 0; $i--) {
        $numbers[$i]++;

        if ($numbers[$i] === 10) {
            $numbers[$i] = 0;
        } else {
            $carry = 0;

            break;
        }
    }

    return ($carry ? '1' : '').implode('', $numbers);
}

function decrement_string(string $number)
{
    if (! preg_match('/^\d+$/', $number)) {
        throw new RuntimeException('The string should be fully numeric');
    }

    if ($number === '0') {
        return '-1';
    }

    $numbers = str_split($number);

    for ($i = count($numbers) - 1; $i >= 0; $i--) {
        $numbers[$i]--;

        if ($numbers[$i] === -1) {
            $numbers[$i] = 9;
        } else {
            break;
        }
    }

    $newNumber = implode('', $numbers);

    return ltrim($newNumber, '0') ?: '0';
}

function string_add(string $a, string $b)
{
    if (! preg_match('/^\d+$/', $a) || ! preg_match('/^\d+$/', $b)) {
        throw new RuntimeException('Can only add two fully numeric strings');
    }

    $length = max(strlen($a), strlen($b));

    $a = str_split(str_pad($a, $length, '0', STR_PAD_LEFT));
    $b = str_split(str_pad($b, $length, '0', STR_PAD_LEFT));

    $carry = 0;

    for ($i = $length - 1; $i >= 0; $i--) {
        $sum = $a[$i] + $b[$i] + $carry;

        $a[$i] = $sum % 10;

        $carry = $sum > 9 ? 1 : 0;
    }

    return ($carry ? '1' : '').implode('', $a);
}

function string_subtract(string $a, string $b)
{
    if (! preg_match('/^\d+$/', $a) || ! preg_match('/^\d+$/', $b)) {
        throw new RuntimeException('Can only subtract two fully numeric strings');
    }

    if ($a === $b) {
        return '0';
    }

    if ($a < $b) {
        throw new RuntimeException('"$a" should be bigger or equal to "$b"');
    }

    $a = str_split($a);
    $b = str_split(str_pad($b, count($a), '0', STR_PAD_LEFT));

    $carry = 0;

    for ($i = count($a) - 1; $i >= 0; $i--) {
        $sub = $a[$i] - $b[$i] - $carry;

        $a[$i] = ($sub >= 0) ? $sub : 10 - abs($sub);

        $carry = $a[$i] !== $sub ? 1 : 0;
    }

    return ltrim(implode('', $a), '0');
}

function string_number_format($string)
{
    $chars = array_reverse(str_split($string));

    $string = '';

    for ($i = 0; $i < count($chars); $i++) {
        if ($i && $i % 3 === 0) {
            $string .= ',';
        }

        $string .= $chars[$i];
    }

    return strrev($string);
}

function print_biggest_page_number($pageNumber, $maxPageNumber)
{
    $pageNumber = str_pad($pageNumber, $length = strlen($maxPageNumber), '0', STR_PAD_LEFT);

    for ($i = 0; $i < $length; $i++) {
        if ($pageNumber[$i] !== $maxPageNumber[$i]) {
            break;
        }
    }

    return $i === 0
        ? $pageNumber
        : '<strong>'.substr_replace($pageNumber, '</strong>', $i, 0);
}

function print_smallest_page_number($pageNumber, $maxPageNumber)
{
    $leadingZeroesCount = strlen($maxPageNumber) - strlen($pageNumber);

    return $leadingZeroesCount === 0
        ? $pageNumber
        : '<strong>'.str_repeat('0', $leadingZeroesCount).'</strong>'.$pageNumber;
}

function allow_robots($coinType, $pageNumber)
{
    switch ($coinType) {
        case CoinType::BITCOIN:
            return BitcoinPageNumber::allowRobots($pageNumber);
        case CoinType::ETHEREUM:
            return EthereumPageNumber::allowRobots($pageNumber);
    }

    throw new RuntimeException('Invalid coin type: '. $coinType);
}
