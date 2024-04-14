<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ReferenceController extends Controller
{
  public function fetchNews() {
    
    return Cache::remember('polygon.reference.news', now()->addMinutes(10), function () {
        $apiKey = env('POLYGON_API_KEY');

        $response = Http::get("https://api.polygon.io/v2/reference/news?apiKey={$apiKey}");

        return $response->body();
    });
  }
}
