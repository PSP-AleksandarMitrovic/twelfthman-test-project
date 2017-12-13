<?php

Route::group(['prefix' => '/v1/filesystem', 'namespace' => 'App\Modules\FileSystem\Controllers'],
function(){
    Route::get("/", 'ResourceController@index');

    Route::post("/", 'ResourceController@store');

    Route::patch("/{id}", 'ResourceController@index');

    Route::delete("/{id}", 'ResourceController@index');

    Route::get("/{id}", 'ResourceController@show');
});
