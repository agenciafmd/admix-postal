<?php

use Agenciafmd\Postal\Http\Controllers\PostalController;

Route::get('postal', [PostalController::class, 'index'])
    ->name('admix.postal.index')
    ->middleware('can:view,\Agenciafmd\Postal\Postal');
Route::get('postal/trash', [PostalController::class, 'index'])
    ->name('admix.postal.trash')
    ->middleware('can:restore,\Agenciafmd\Postal\Postal');
Route::get('postal/create', [PostalController::class, 'create'])
    ->name('admix.postal.create')
    ->middleware('can:create,\Agenciafmd\Postal\Postal');
Route::post('postal', [PostalController::class, 'store'])
    ->name('admix.postal.store')
    ->middleware('can:create,\Agenciafmd\Postal\Postal');
Route::get('postal/{postal}', [PostalController::class, 'show'])
    ->name('admix.postal.show')
    ->middleware('can:view,\Agenciafmd\Postal\Postal');
Route::get('postal/{postal}/edit', [PostalController::class, 'edit'])
    ->name('admix.postal.edit')
    ->middleware('can:update,\Agenciafmd\Postal\Postal');
Route::put('postal/{postal}', [PostalController::class, 'update'])
    ->name('admix.postal.update')
    ->middleware('can:update,\Agenciafmd\Postal\Postal');
Route::delete('postal/destroy/{postal}', [PostalController::class, 'destroy'])
    ->name('admix.postal.destroy')
    ->middleware('can:delete,\Agenciafmd\Postal\Postal');
Route::post('postal/{id}/restore', [PostalController::class, 'restore'])
    ->name('admix.postal.restore')
    ->middleware('can:restore,\Agenciafmd\Postal\Postal');
Route::post('postal/batchDestroy', [PostalController::class, 'batchDestroy'])
    ->name('admix.postal.batchDestroy')
    ->middleware('can:delete,\Agenciafmd\Postal\Postal');
Route::post('postal/batchRestore', [PostalController::class, 'batchRestore'])
    ->name('admix.postal.batchRestore')
    ->middleware('can:restore,\Agenciafmd\Postal\Postal');
Route::post('postal/{postal}/send', [PostalController::class, 'send'])
    ->name('admix.postal.send')
    ->middleware('can:update,\Agenciafmd\Postal\Postal');

//Route::post('postal/{postal}/enviar', 'PostalFrontendController@send')
//    ->name('frontend.postal.send')
//    ->withoutMiddleware(['auth:admix-web']);
