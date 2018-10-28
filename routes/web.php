<?php

Route::get('/', 'ArtistController@index');
Route::get('{artistId}', 'ArtistController@get')->name('artist');
