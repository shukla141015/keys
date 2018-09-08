<?php

Route::view('/', 'home')->name('home');

Route::view('/about', 'about')->name('about');

Route::get('/bitcoin',                       ['uses' => 'BitcoinPagesController@index',      'as' => 'btcPages.index']);
Route::get('/bitcoin/random',                ['uses' => 'BitcoinPagesController@randomPage', 'as' => 'btcPages.random']);
Route::get('/bitcoin/you-have-gone-too-far', ['uses' => 'BitcoinPagesController@pageTooBig', 'as' => 'btcPages.pageTooBig']);
Route::get('/bitcoin/{pageNumber?}',         ['uses' => 'BitcoinPagesController@keysPage',   'as' => 'btcPages']);
Route::redirect('/btc', '/bitcoin');

Route::get('/ethereum',                       ['uses' => 'EthereumPagesController@index',      'as' => 'ethPages.index']);
Route::get('/ethereum/random',                ['uses' => 'EthereumPagesController@randomPage', 'as' => 'ethPages.random']);
Route::get('/ethereum/you-have-gone-too-far', ['uses' => 'EthereumPagesController@pageTooBig', 'as' => 'ethPages.pageTooBig']);
Route::get('/ethereum/{pageNumber?}',         ['uses' => 'EthereumPagesController@keysPage',   'as' => 'ethPages']);
Route::redirect('/eth', '/ethereum');
