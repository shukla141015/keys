<?php

Route::view('/', 'home')->name('home');

Route::get('/bitcoin/random',                ['uses' => 'BitcoinPagesController@randomPage', 'as' => 'btcPages.random']);
Route::get('/bitcoin/you-have-gone-too-far', ['uses' => 'BitcoinPagesController@pageTooBig', 'as' => 'btcPages.pageTooBig']);
Route::get('/bitcoin/{pageNumber?}',         ['uses' => 'BitcoinPagesController@index',      'as' => 'btcPages']);

Route::redirect('/btc', '/bitcoin/1');

// Route::get('/ethereum/{pageNumber?}', ['uses' => 'BitcoinPagesController@index',       'as' => 'ethPages']);
