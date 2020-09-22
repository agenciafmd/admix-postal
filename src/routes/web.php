<?php

use Agenciafmd\Postal\Http\Controllers\PostalController;
use Agenciafmd\Postal\Models\Postal;

Route::get('postal', [PostalController::class, 'index'])
    ->name('admix.postal.index')
    ->middleware('can:view,' . Postal::class);
Route::get('postal/trash', [PostalController::class, 'index'])
    ->name('admix.postal.trash')
    ->middleware('can:restore,' . Postal::class);
Route::get('postal/create', [PostalController::class, 'create'])
    ->name('admix.postal.create')
    ->middleware('can:create,' . Postal::class);
Route::post('postal', [PostalController::class, 'store'])
    ->name('admix.postal.store')
    ->middleware('can:create,' . Postal::class);
Route::get('postal/{postal}/edit', [PostalController::class, 'edit'])
    ->name('admix.postal.edit')
    ->middleware('can:update,' . Postal::class);
Route::put('postal/{postal}', [PostalController::class, 'update'])
    ->name('admix.postal.update')
    ->middleware('can:update,' . Postal::class);
Route::delete('postal/destroy/{postal}', [PostalController::class, 'destroy'])
    ->name('admix.postal.destroy')
    ->middleware('can:delete,' . Postal::class);
Route::post('postal/{id}/restore', [PostalController::class, 'restore'])
    ->name('admix.postal.restore')
    ->middleware('can:restore,' . Postal::class);
Route::post('postal/batchDestroy', [PostalController::class, 'batchDestroy'])
    ->name('admix.postal.batchDestroy')
    ->middleware('can:delete,' . Postal::class);
Route::post('postal/batchRestore', [PostalController::class, 'batchRestore'])
    ->name('admix.postal.batchRestore')
    ->middleware('can:restore,' . Postal::class);
Route::post('postal/{postal}/send', [PostalController::class, 'send'])
    ->name('admix.postal.send')
    ->middleware('can:update,' . Postal::class);

//Route::post('postal/{postal}/enviar', 'PostalFrontendController@send')
//    ->name('frontend.postal.send')
//    ->withoutMiddleware(['auth:admix-web']);
