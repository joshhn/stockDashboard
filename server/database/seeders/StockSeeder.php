<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Stock;


class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('ALTER TABLE stocks AUTO_INCREMENT = 1;');

        $apiKey = env('POLYGON_API_KEY');
        
        $url = "https://api.polygon.io/v3/reference/tickers?limit=1000";
        
        while ($url) {
          $response = Http::get("$url&apiKey={$apiKey}");
          
          if ($response->successful()) {
              $data = $response->json();
              
              foreach ($data['results'] as $item) {
                  if (!Stock::where('ticker', $item['ticker'])->exists()) {
                      $name = array_key_exists('name', $item) ? $item['name'] : '';
                      Stock::create(['ticker' => $item['ticker'], 'name' => $name]);
                  }
              }
              
              $url = array_key_exists('next_url', $data) ? $data['next_url'] : null;
              $count = $data['count'];
              $this->command->info("Added {$count} tickers");
              sleep(12); // 5 requests per minute for API free tier
          } else {
              $this->command->error('Failed to retrieve data from Polygon.io API.');
              break;
          }
      }
      
      $this->command->info('Stocks seeded successfully.');
    }
}
