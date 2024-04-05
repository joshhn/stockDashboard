<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\User;
use App\Models\Watchlist;
use App\Models\Stock;

class WatchlistStockTest extends TestCase
{
    use RefreshDatabase;
    
    protected $user, $stocks;
    private $count = 10;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->stocks = Stock::factory()->count($this->count)->create();
    }

    public function test_get_stocks_from_watchlist()
    {
        $watchlist = Watchlist::factory()->create(['user_id' => $this->user->id]);

        $watchlist->stocks()->attach($this->stocks);

        $response = $this->getJson("/api/watchlists/{$watchlist->id}/stocks");
        $response->assertOk()->assertJsonCount($this->count);

        $response = $this->getJson("/api/watchlists/9999/stocks");
        $response->assertNotFound();
    }

    public function test_add_stock_to_watchlist()
    {
        $watchlist = Watchlist::factory()->create(['user_id' => $this->user->id]);

        $stock = $this->stocks[random_int(0, $this->count - 1)];

        $response = $this->postJson("/api/watchlists/{$watchlist->id}/stocks", ['symbol' => $stock->symbol]);

        $response->assertCreated();
        $this->assertDatabaseHas('watchlist_stock', [
            'watchlist_id' => $watchlist->id,
            'stock_id' => $stock->id,
        ]);

        $response = $this->postJson("/api/watchlists/{$watchlist->id}/stocks", ['symbol' => $stock->symbol]);
        $response->assertConflict();

        $response = $this->postJson("/api/watchlists/{$watchlist->id}/stocks", ['symbol' => 'NONESYMBOL']);
        $response->assertUnprocessable();

        $response = $this->postJson("/api/watchlists/99999/stocks", ['symbol' => 'NONESYMBOL']);
        $response->assertUnprocessable();
    }

    public function test_remove_stock_from_watchlist()
    {
        $watchlist = Watchlist::factory()->create(['user_id' => $this->user->id]);

        $stock = $this->stocks[random_int(0, $this->count - 1)];
        $watchlist->stocks()->attach($stock);

        $response = $this->deleteJson("/api/watchlists/{$watchlist->id}/stocks/{$stock->symbol}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('watchlist_stock', [
            'watchlist_id' => $watchlist->id,
            'stock_id' => $stock->id,
        ]);
    }
}
