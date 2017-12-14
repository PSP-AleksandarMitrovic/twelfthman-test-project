<?php

Route::group(['prefix' => '/v1/filesystem', 'namespace' => 'App\Modules\FileSystem\Controllers'],
    function()  {
        Route::get("/{folderName}/{fileName}", 'ResourceController@show');

        Route::post("/{folderName}/{fileName}", 'ResourceController@store');
    }
);
