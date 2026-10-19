<?php

use App\Http\Controllers\RecetaController;
use Illuminate\Support\Facades\Route;

Route::get('/recetas/populares', [RecetaController::class, 'populares']);
