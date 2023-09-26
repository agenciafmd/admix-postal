<?php

use Agenciafmd\Postal\Http\Livewire\Pages;

Route::get('/postal', Pages\Postal\Index::class)
    ->name('admix.postal.index');
Route::get('/postal/trash', Pages\Postal\Index::class)
    ->name('admix.postal.trash');
Route::get('/postal/create', Pages\Postal\Form::class)
    ->name('admix.postal.create');
Route::get('/postal/{postal}/edit', Pages\Postal\Form::class)
    ->name('admix.postal.edit');
