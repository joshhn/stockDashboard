<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Models\Watchlist;
use App\Models\Stock;

class WatchlistStockController extends Controller
{
    // return all stocks from a watchlist
    public function index(Request $request, string $watchlistId)
    {
        $watchlist = Auth::user()->watchlists()->findOrFail($watchlistId);

        $stocks = $watchlist->stocks()->get();

        return response()->json($stocks, JsonResponse::HTTP_OK);
    }

    // Add stock to a watchlist
    public function store(Request $request, string $watchlistId)
    {
        $validated = $request->validate(['ticker' => 'required|string|max:255|uppercase|exists:stocks,ticker']);
        $watchlist = Auth::user()->watchlists()->findOrFail($watchlistId);
        $stockId = Stock::where('ticker', $request->input('ticker'))->first()->id;
        if ($watchlist->stocks()->where('stock_id', $stockId)->exists()) {
            return response()->json(['error' => 'Stock already added to the watchlist'], JsonResponse::HTTP_CONFLICT);
        }
        $watchlist->stocks()->attach($stockId);

        return response()->json(['message' => 'Success'], JsonResponse::HTTP_CREATED);
    }

    // Remove stock from a watchlist
    public function destroy(string $watchlistId, string $ticker)
    {
        Validator::make(['ticker' => $ticker], ['ticker' => 'required|string|uppercase|max:255|exists:stocks,ticker'])->validate();
        $watchlist = Auth::user()->watchlists()->findOrFail($watchlistId);
        $stockId = Stock::where('ticker', $ticker)->first()->id;
        if ($watchlist->stocks()->where('stock_id', $stockId)->doesntExist()) {
            return response()->json(['error' => 'Stock was not in the watchlist'], JsonResponse::HTTP_CONFLICT);
        }
        $watchlist->stocks()->detach($stockId);
    
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
