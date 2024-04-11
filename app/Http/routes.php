<?php

use Symfony\Component\Console\Input\Input;

Route::get('/whatToDo', function () {
    return redirect('/core/publik/whatToDo');
});

Route::group(
    [
        'middleware' => ['web', 'auth'],
    ],
    function () {
        Route::post('shopeeKiriman', 'ShopeeController@kiriman')->name('shopeeKiriman');
    });

Route::group(['middleware' => ['web', 'auth']], function () {

        Route::get('cabang/{cabang}', 'CabangController@index');
        Route::get('shopeeconnect/{marketplace}', 'ShopeeController@connect')->name('shopeeconnect');
        Route::get('tokopediaconnect', 'TokopediaController@connect')->name('tokopediaconnect');
    // Route::resource('marketing', 'Marketing\MarketingController')->except(['destroy']);

    // Route::post('authorization/ubah', 'AuthorizationController@ubah');
    // Route::resource('authorization', 'AuthorizationController');
    // Route::resource('role', 'RoleController');
    // Route::get('role/create', 'RoleController@edit');
    // Route::post('role', 'RoleController@update');

    // Route::get('api/supplier', function () {
    //     $queryString = $_GET['queryString'];
    //     $supplier = supplier::where('nama', 'like','%'.$queryString.'%')->get();
    //     return response()->json($supplier);
    // });

});
