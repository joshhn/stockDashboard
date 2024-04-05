<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Tests\TestCase;
use App\Models\Stock;


class StockTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleWare;

    public function test_stock_create()
    {
        $response = $this->postJson('/api/stocks', ['symbol' => 'AAPL']);

        $response->assertCreated()->assertJsonStructure(['id', 'symbol']);

        $this->assertDatabaseHas('stocks', ['symbol' => 'AAPL']);

        $response = $this->postJson('/api/stocks', ['symbol' => 'AAPL']);

        $response->assertUnprocessable()->assertJsonValidationErrorFor('symbol');
    }

    public function test_stock_index()
    {
        $stocks = Stock::factory()->count(5)->create();

        $response = $this->getJson('/api/stocks/');
        $response->assertOk()->assertJsonCount(5);
    }

    public function test_stock_show()
    {
        $stocks = Stock::factory()->count(5)->create();

        $response = $this->getJson('/api/stocks/'.$stocks[0]->id);
        $response->assertOk()->assertJsonFragment(['id' => $stocks[0]->id]);
    }

    public function test_stocks_update()
    {
        $stocks = Stock::factory()->count(5)->create();

        $response = $this->putJson('/api/stocks/'.$stocks[0]->id, ['symbol' => 'NVIDIA']);
        $response->assertOk()->assertJsonStructure(['id', 'symbol']);
        $this->assertDatabaseHas('stocks', ['id' => $stocks[0]->id, 'symbol' => 'NVIDIA']);

        $response = $this->putJson('/api/stocks/'.$stocks[0]->id, ['symbol' => 'NVIDIA']);
        $response->assertUnprocessable()->assertJsonValidationErrorFor('symbol');
    }

    public function test_watchlist_delete()
    {
        $stocks = Stock::factory()->count(5)->create();

        $response = $this->deleteJson('/api/stocks/'.$stocks[0]->id);
        $response->assertNoContent();
        
        $this->assertDatabaseMissing('stocks', ['id' => $stocks[0]->id]);

        $response = $this->deleteJson('/api/stocks/'.$stocks[0]->id);
        $response->assertNotFound();
    }
}
