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

    protected $stocks, $stock;
    private $count = 10;

    protected function setUp(): void
    {
        parent::setUp();
        $this->stocks = Stock::factory()->count($this->count)->create();
        $this->stock = $this->stocks[random_int(0, $this->count - 1)];
    }

    public function test_stock_create()
    {
        $response = $this->postJson('/api/stocks', ['symbol' => 'NVIDIA']);

        $response->assertCreated()->assertJsonStructure(['id', 'symbol']);

        $this->assertDatabaseHas('stocks', ['symbol' => 'NVIDIA']);

        $response = $this->postJson('/api/stocks', ['symbol' => $this->stock->symbol]);

        $response->assertUnprocessable()->assertJsonValidationErrorFor('symbol');
    }

    public function test_stock_index()
    {
        $response = $this->getJson('/api/stocks/');
        $response->assertOk()->assertJsonCount($this->count);
    }

    public function test_stock_show()
    {
        $response = $this->getJson('/api/stocks/'.$this->stock->id);
        $response->assertOk()->assertJsonFragment(['id' => $this->stock->id]);
    }

    public function test_stocks_update()
    {
        $response = $this->putJson('/api/stocks/'.$this->stock->id, ['symbol' => 'NVIDIA']);
        $response->assertOk()->assertJsonStructure(['id', 'symbol']);
        $this->assertDatabaseHas('stocks', ['id' => $this->stock->id, 'symbol' => 'NVIDIA']);

        $response = $this->putJson('/api/stocks/'.$this->stock->id, ['symbol' => 'NVIDIA']);
        $response->assertUnprocessable()->assertJsonValidationErrorFor('symbol');
    }

    public function test_stock_delete()
    {
        $response = $this->deleteJson('/api/stocks/'.$this->stock->id);
        $response->assertNoContent();
        
        $this->assertDatabaseMissing('stocks', ['id' => $this->stock->id]);

        $response = $this->deleteJson('/api/stocks/'.$this->stock->id);
        $response->assertNotFound();
    }
}
