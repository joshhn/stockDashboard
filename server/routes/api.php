<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReferenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchlistsController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\WatchlistStockController;
use App\Http\Middleware\ForceJsonResponse;

// routes for auth
Route::controller(UserController::class)->group(function () {
  Route::post('/register', 'register');
  Route::post('/login', 'login');
  Route::post('/logout', 'logout');
});

// routes for reference
Route::controller(ReferenceController::class)->group(function () {
  Route::get('/reference/news', 'fetchNews');
});

//routes for stocks -- public
Route::controller(StocksController::class)->group(function () {
  Route::get('/stocks', 'index');
  Route::get('/stocks/{symbol}', 'show');
  Route::get('/search/stocks', 'search');
});

Route::middleware('auth:sanctum')->group(function () {
  // routes for user
  Route::get('/user', function (Request $request) {
    return $request->user();
  });

  // routes for watchlists
  Route::controller(WatchlistsController::class)->group(function () {
    Route::get('/watchlists', 'index'); // get all watchlists
    Route::get('/watchlists/{id}', 'show'); // get watchlist by id
    Route::post('/watchlists', 'store'); // create new watchlist
    Route::put('/watchlists/{id}', 'update'); // edit watchlist
    Route::delete('/watchlists/{id}', 'destroy'); // delete watchlist
  });

  // routes for stocks
  Route::controller(StocksController::class)->group(function () {
    Route::post('/stocks', 'store');
    Route::put('/stocks/{symbol}', 'update');
    Route::delete('/stocks/{symbol}', 'destroy');
  });

  // routes for watchlist & stocks management
  Route::controller(WatchlistStockController::class)->group(function () {
    Route::get('/watchlists/{watchlistId}/stocks', 'index');
    Route::post('/watchlists/{watchlistId}/stocks', 'store');
    Route::delete('/watchlists/{watchlistId}/stocks/{stockSymbol}', 'destroy');
  });
});
