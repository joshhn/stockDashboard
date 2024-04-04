<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Models\Stocks;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stocks::all();
        return response()->json($stocks, JsonResponse::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(['symbol' => 'required|string|max:255|unique:stocks,symbol']);

        $stock = Stocks::create($validated);
        return response()->json($stock, JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = Stocks::findOrFail($id);
        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(['symbol' => 'required|string|max:255|unique:stocks,symbol']);
        $stock = Stocks::findOrFail($id);
        $stock->update($validated);

        return response()->json($stock, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = Stocks::findOrFail($id);
        $stock->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
