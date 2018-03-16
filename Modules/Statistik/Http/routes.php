<?php

Route::group(['middleware' => 'web', 'prefix' => 'statistik', 'namespace' => 'Modules\Statistik\Http\Controllers'], function()
{
    Route::get('/', 'StatistikController@index');
});
