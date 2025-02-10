<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/', [EventController::class, 'index'])->name('events.index');
Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
Route::put('/event/update/{id}', [EventController::class, 'update'])->name('event.update');
Route::delete('/event/delete/{id}', [EventController::class, 'delete'])->name('event.delete');
