<?php

Route::group(['namespace'=>'Mihai\Weather\Http\Controllers'],function(){

Route::get('weather','ForecastController@weather')->name('weather');
Route::post('weather','ForecastController@forecast')->name('forecast');

});

