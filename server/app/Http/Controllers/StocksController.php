<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\Stock;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $stocks = Stock::take($limit)->get();
        return response()->json($stocks, JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['symbol' => 'required|string|max:255|unique:stocks,symbol']);

        $stock = Stock::create($validated);
        return response()->json($stock, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $symbol)
    {   
        $stock = Stock::where('symbol', $symbol)->firstOrFail();
        return Cache::remember('polygon.reference.stocks.show.'.$symbol, now()->addMinutes(10), function () use ($symbol) {
            $apiKey = env('POLYGON_API_KEY');
    
            $response = Http::get("https://api.polygon.io/v3/reference/tickers/{$symbol}?apiKey={$apiKey}");
    
            return $response->body();
        });
    }

    // search database for symbol match
    public function search(Request $request) {
        $query = $request->input('query', '');
        $limit = $request->input('limit', 5);

        $stocks = Stock::where('symbol', 'like', "%{$query}%")->take($limit)->get();
        return response()->json($stocks, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $symbol)
    {
        $validated = $request->validate(['symbol' => 'required|string|max:255|unique:stocks,symbol']);
        $stock = Stock::where('symbol', $symbol)->firstOrFail();
        $stock->update($validated);

        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $symbol)
    {
        $stock = Stock::where('symbol', $symbol)->firstOrFail();
        $stock->delete();

        $stock->watchlists()->detach(); // removing this stocks from all associated watchlists

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
