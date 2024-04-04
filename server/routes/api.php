<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchlistsController;
use App\Http\Middleware\ForceJsonResponse;

Route::get('/user', function (Request $request) {
  return $request->user();
})->middleware('auth:sanctum');

// routes for auth
Route::withoutMiddleware([ForceJsonResponse::class])->group(function () {
  Route::controller(UserController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout');
  });
});

Route::middleware('auth:sanctum')->group(function () {
  // routes for watchlists
  Route::controller(WatchlistsController::class)->group(function () {
    Route::get('/watchlists', 'index'); // get all watchlists
    Route::get('/watchlists/{id}', 'show'); // get watchlist by id
    Route::post('/watchlists', 'store'); // create new watchlist
    Route::put('/watchlists/{id}', 'update'); // edit watchlist
    Route::delete('/watchlists/{id}', 'destroy'); // delete watchlist
  });
});
