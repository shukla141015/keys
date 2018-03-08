<?php

if (app()->environment('local')) {
    Route::get('mock-balance', function () {
        $publicKeys = explode('|', request()->query('active'));

        return array_map(function ($index) {
            $usedBefore = random_int(0, 100) > 80;

            $hasBalance = $usedBefore && random_int(0, 100) > 80;

            return [
                'final_balance'  => $finalBalance = ($hasBalance ? random_int(1, 1204568646) : 0),
                'n_tx'           => $usedBefore ? random_int(5, 150) : 0,
                'total_received' => $usedBefore ? random_int($finalBalance, 2204568646) : 0,
            ];
        }, array_flip($publicKeys));
    });
}
