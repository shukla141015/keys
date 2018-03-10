<?php

/**
 * @param $path
 * @param null|string $disk
 *
 * @return string Absolute path to a file from the storage facade
 */
function storage_disk_file_path($path, $disk = null)
{
    $disk = $disk ?: env('FILESYSTEM_DRIVER');

    $storagePath = \Storage::disk($disk)->getDriver()->getAdapter()->getPathPrefix();

    return str_finish($storagePath, '/').ltrim($path, '/');
}

function interval(int $interval, $closure)
{
    $interval = ($interval === 0) ? 1 : $interval;

    static $calls = [];

    $caller = sha1(debug_backtrace()[0]['file'].'|'.debug_backtrace()[0]['line']);

    $callCount = $calls[$caller] ?? 1;

    if ($callCount % $interval === 0) {
        $closure();
    }

    $calls[$caller] = $callCount + 1;
}

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

    return $carry === 1
        ? '1'.implode('', $numbers)
        : implode('', $numbers);
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

    return ltrim($newNumber, '0')
        ? ltrim($newNumber, '0')
        : '0';
}
