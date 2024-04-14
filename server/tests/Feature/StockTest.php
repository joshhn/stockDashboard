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
        $response = $this->postJson('/api/stocks', ['ticker' => 'NVIDIA', 'name' => 'NVIDIA']);
        $response->assertCreated()->assertJsonStructure(['id', 'ticker']);

        $this->assertDatabaseHas('stocks', ['ticker' => 'NVIDIA']);

        $response = $this->postJson('/api/stocks', ['ticker' => $this->stock->ticker]);

        $response->assertUnprocessable()->assertJsonValidationErrorFor('ticker');
    }

    public function test_stock_index()
    {
        $response = $this->getJson('/api/stocks/');
        $response->assertOk()->assertJsonCount($this->count);
    }

    // public function test_stock_show()
    // {
    //     $response = $this->getJson('/api/stocks/'.$this->stock->ticker);
    //     $response->assertOk()->assertJsonFragment(['ticker' => $this->stock->ticker]);
    // }

    public function test_stocks_update()
    {
        $response = $this->putJson('/api/stocks/'.$this->stock->ticker, ['ticker' => 'NVIDIA', 'name' => 'NVIDIA']);
        $response->assertOk()->assertJsonStructure(['id', 'ticker']);
        $this->assertDatabaseHas('stocks', ['id' => $this->stock->id, 'ticker' => 'NVIDIA', 'name' => 'NVIDIA']);

        $response = $this->putJson('/api/stocks/'.$this->stock->ticker, ['ticker' => 'NVIDIA']);
        $response->assertUnprocessable()->assertJsonValidationErrorFor('ticker');
    }

    public function test_stock_delete()
    {
        $response = $this->deleteJson('/api/stocks/'.$this->stock->ticker);
        $response->assertNoContent();
        
        $this->assertDatabaseMissing('stocks', ['id' => $this->stock->id]);

        $response = $this->deleteJson('/api/stocks/'.$this->stock->ticker);
        $response->assertNotFound();
    }
}
