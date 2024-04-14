<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReferenceController extends Controller
{
  public function fetchNews() {
    $apiKey = env('POLYGON_API_KEY');
        
    $response = Http::get("https://api.polygon.io/v2/reference/news?apiKey={$apiKey}");

    return $response->json();
  }
}
