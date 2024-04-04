<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Stock;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::all();
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
    public function show(string $id)
    {
        $stock = Stock::findOrFail($id);
        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(['symbol' => 'required|string|max:255|unique:stocks,symbol']);
        $stock = Stock::findOrFail($id);
        $stock->update($validated);

        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        $stock->watchlists()->detach(); // removing this stocks from all associated watchlists

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
