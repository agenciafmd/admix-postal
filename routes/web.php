<?php

use Agenciafmd\Postal\Livewire\Pages;

Route::get('/postal', Pages\Postal\Index::class)
    ->name('admix.postal.index');
Route::get('/postal/trash', Pages\Postal\Index::class)
    ->name('admix.postal.trash');
Route::get('/postal/create', Pages\Postal\Component::class)
    ->name('admix.postal.create');
Route::get('/postal/{postal}/edit', Pages\Postal\Component::class)
    ->name('admix.postal.edit');
