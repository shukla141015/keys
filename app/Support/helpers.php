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
