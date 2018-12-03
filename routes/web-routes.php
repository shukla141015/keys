<?php

Route::view('/', 'home')->name('home');

Route::view('/about', 'about')->name('about');

Route::get('/statistics', 'StatisticsPageController')->name('stats');

Route::get('/are-you-human',  ['uses' => 'HumanVerificationController@index', 'as' => 'humanVerification']);
Route::post('/are-you-human', ['uses' => 'HumanVerificationController@post',  'as' => 'humanVerification.post']);

Route::get('/bitcoin',                       ['uses' => 'BitcoinPagesController@index',      'as' => 'btcPages.index']);
Route::get('/bitcoin/search',                ['uses' => 'BitcoinPagesController@showSearch', 'as' => 'btcPages.search']);
Route::post('/bitcoin/search',               ['uses' => 'BitcoinPagesController@search',     'as' => 'btcPages.search']);
Route::get('/bitcoin/random',                ['uses' => 'BitcoinPagesController@randomPage', 'as' => 'btcPages.random']);
Route::get('/bitcoin/statistics',            ['uses' => 'BitcoinPagesController@stats',      'as' => 'btcPages.stats']);
Route::get('/bitcoin/you-have-gone-too-far', ['uses' => 'BitcoinPagesController@pageTooBig', 'as' => 'btcPages.pageTooBig']);
Route::get('/bitcoin/{pageNumber?}',         ['uses' => 'BitcoinPagesController@keysPage',   'as' => 'btcPages']);
Route::redirect('/btc', '/bitcoin');

Route::get('/ethereum',                       ['uses' => 'EthereumPagesController@index',      'as' => 'ethPages.index']);
Route::get('/ethereum/random',                ['uses' => 'EthereumPagesController@randomPage', 'as' => 'ethPages.random']);
Route::get('/ethereum/statistics',            ['uses' => 'EthereumPagesController@stats',      'as' => 'ethPages.stats']);
Route::get('/ethereum/you-have-gone-too-far', ['uses' => 'EthereumPagesController@pageTooBig', 'as' => 'ethPages.pageTooBig']);
Route::get('/ethereum/{pageNumber?}',         ['uses' => 'EthereumPagesController@keysPage',   'as' => 'ethPages']);
Route::redirect('/eth', '/ethereum');
