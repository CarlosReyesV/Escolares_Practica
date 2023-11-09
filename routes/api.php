<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EscuelaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Get
Route::get('/school', [EscuelaController::class, 'index']);
// Create
Route::post('/school', [EscuelaController::class, 'store']);
// Update
Route::put('/school', [EscuelaController::class, 'update']);
// Delete
Route::delete('/school/{id}', [EscuelaController::class, 'destroy']);
//Search bar
Route::get('/school/searchbar/{id}', [EscuelaController::class, 'searchbar'])->name('school.search');