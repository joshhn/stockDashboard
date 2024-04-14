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
        $validated = $request->validate(['ticker' => 'required|string|max:255|unique:stocks,ticker', 'name' => 'required|string']);

        $stock = Stock::create($validated);
        return response()->json($stock, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $ticker)
    {   
        $stock = Stock::where('ticker', $ticker)->firstOrFail();
        return Cache::remember('polygon.reference.stocks.show.'.$ticker, now()->addMinutes(10), function () use ($ticker) {
            $apiKey = env('POLYGON_API_KEY');
    
            $response = Http::get("https://api.polygon.io/v3/reference/tickers/{$ticker}?apiKey={$apiKey}");
    
            return $response->body();
        });
    }

    // search database for ticker match
    public function search(Request $request) {
        $query = $request->input('query', '');
        $limit = $request->input('limit', 5);

        $stocks = Stock::where('ticker', 'like', "%{$query}%")
          ->orWhere('name', 'like', "%{$query}%")
          ->orderByRaw("CASE WHEN ticker LIKE '{$query}%' THEN 0 ELSE 1 END")
          ->take($limit)->get();
        return response()->json($stocks, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ticker)
    {
        $validated = $request->validate(['ticker' => 'required|string|max:255|unique:stocks,ticker', 'name' => 'required|string']);
        $stock = Stock::where('ticker', $ticker)->firstOrFail();
        $stock->update($validated);

        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ticker)
    {
        $stock = Stock::where('ticker', $ticker)->firstOrFail();
        $stock->delete();

        $stock->watchlists()->detach(); // removing this stocks from all associated watchlists

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
