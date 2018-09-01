<?php

Route::get('realistic-balance', function () {
    $publicKeys = explode('|', request()->query('active'));

    $keys = array_flip($publicKeys);

    return array_map(function ($index) {
        return ['final_balance' => 0, 'n_tx' => 0, 'total_received' => 0];
    }, $keys);
});

Route::get('mock-balance', function () {
    $publicKeys = explode('|', request()->query('active'));

    $keys = array_flip($publicKeys);

    return array_map(function ($index) {
        $usedBefore = random_int(0, 100) > 80;

        $hasBalance = $usedBefore && random_int(0, 100) > 80;

        return [
            'final_balance'  => $finalBalance = ($hasBalance ? random_int(1, 1204568646) : 0),
            'n_tx'           => $usedBefore ? random_int(5, 150) : 0,
            'total_received' => $usedBefore ? random_int($finalBalance, 2204568646) : 0,
        ];
    }, $keys);
});


Route::get('eth/balance-empty', function () {
    $publicKeys = explode(',', request()->query('address'));

    $keys = array_map(function ($publicKey) {
        return ['account' => $publicKey, 'balance' => '0'];
    }, $publicKeys);

    return [
        'status' => '1',
        'message' => 'OK',
        'result' => $keys,
    ];
});
