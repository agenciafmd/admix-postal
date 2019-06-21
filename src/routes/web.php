<?php

/*
|--------------------------------------------------------------------------
| POSTAL Routes
|--------------------------------------------------------------------------
*/

Route::prefix(config('admix.url') . '/postal')
    ->name('admix.postal.')
    ->middleware(['auth:admix-web'])
    ->group(function () {
        Route::get('', 'PostalController@index')
            ->name('index')
            ->middleware('can:view,\Agenciafmd\Postal\Postal');
        Route::get('trash', 'PostalController@index')
            ->name('trash')
            ->middleware('can:restore,\Agenciafmd\Postal\Postal');
        Route::get('create', 'PostalController@create')
            ->name('create')
            ->middleware('can:create,\Agenciafmd\Postal\Postal');
        Route::post('', 'PostalController@store')
            ->name('store')
            ->middleware('can:create,\Agenciafmd\Postal\Postal');
        Route::get('{postal}', 'PostalController@show')
            ->name('show')
            ->middleware('can:view,\Agenciafmd\Postal\Postal');
        Route::get('{postal}/edit', 'PostalController@edit')
            ->name('edit')
            ->middleware('can:update,\Agenciafmd\Postal\Postal');
        Route::put('{postal}', 'PostalController@update')
            ->name('update')
            ->middleware('can:update,\Agenciafmd\Postal\Postal');
        Route::delete('destroy/{postal}', 'PostalController@destroy')
            ->name('destroy')
            ->middleware('can:delete,\Agenciafmd\Postal\Postal');
        Route::post('{id}/restore', 'PostalController@restore')
            ->name('restore')
            ->middleware('can:restore,\Agenciafmd\Postal\Postal');
        Route::post('batchDestroy', 'PostalController@batchDestroy')
            ->name('batchDestroy')
            ->middleware('can:delete,\Agenciafmd\Postal\Postal');
        Route::post('batchRestore', 'PostalController@batchRestore')
            ->name('batchRestore')
            ->middleware('can:restore,\Agenciafmd\Postal\Postal');
        Route::post('{postal}/send', 'PostalController@send')
            ->name('send')
            ->middleware('can:update,\Agenciafmd\Postal\Postal');
    });

//Route::name('frontend.postal.')->group(function () {
//    Route::post('postal/{postal}/enviar', 'PostalFrontendController@send')->name('send');
//});
