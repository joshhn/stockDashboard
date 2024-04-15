<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\Watchlist;
use App\Http\Resources\WatchlistResource;

class WatchlistsController extends Controller
{
  public function index() {
    $watchlists = Auth::user()->watchlists;
    return response()->json(WatchlistResource::collection($watchlists), JsonResponse::HTTP_OK);
  }

  public function show(Request $request, string $id) {
    $watchlist = Auth::user()->watchlists()->findOrFail($id);
    return response()->json(new WatchlistResource($watchlist), JsonResponse::HTTP_OK);
  }

  public function store(Request $request) {
    $validated = $request->validate(['name' => 'required|string|max:255']);

    $watchlist = new Watchlist($validated);
    $watchlist->user_id = Auth::id();
    $watchlist->save();
    
    Auth::user()->watchlists()->attach($watchlist->id); // adding to user_watchlists table

    return response()->json(new WatchlistResource($watchlist), JsonResponse::HTTP_CREATED);
  }

  public function update(Request $request, string $id) {
    $validated = $request->validate(['name' => 'required|string|max:255']);

    $watchlist = Auth::user()->watchlists()->findOrFail($id);
    $watchlist->update($validated);

    return response()->json(new WatchlistResource($watchlist), JsonResponse::HTTP_OK);
  }

  public function destroy(string $id) {
    $watchlist = Auth::user()->watchlists()->findOrFail($id);
    $watchlist->delete();

    $watchlist->users()->detach(); // removing all related watchlist records in user_watchlists

    return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
  }
}
