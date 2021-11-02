<?php

use RonasIT\Support\AutoDoc\Http\Controllers\AutoDocController;

Route::get('/auto-doc/documentation', ['uses' => AutoDocController::class . '@documentation']);
Route::get('/auto-doc/{file}', ['uses' => AutoDocController::class . '@getFile']);
foreach (config('auto-doc.routes') as $route) {
    Route::get($route, ['uses' => AutoDocController::class . '@index']);
}
