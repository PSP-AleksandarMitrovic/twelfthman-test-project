<?php

Route::group(['prefix' => '/v1/images', 'namespace' => 'App\Modules\Image\Controllers'],
    function()  {
        Route::get("/", 'ResourceController@index');

        Route::post("/", 'ResourceController@store');

        Route::patch("/{id}", 'ResourceController@update')->where('id', '[0-9]+');

        Route::delete("/{id}", 'ResourceController@delete')->where('id', '[0-9]+');

        Route::get("/{id}", 'ResourceController@show')->where('id', '[0-9]+');
    }
);
