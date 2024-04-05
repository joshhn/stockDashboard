<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

use Tests\TestCase;
use App\Models\User;
use App\Models\Watchlist;

class WatchlistTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthorized(): void
    {
        $response = $this->getJson('/api/watchlists');
        $response->assertUnauthorized();

        $response = $this->getJson('/api/watchlists/1');
        $response->assertUnauthorized();

        $response = $this->postJson('/api/watchlists');
        $response->assertUnauthorized();

        $response = $this->putJson('/api/watchlists/1');
        $response->assertUnauthorized();

        $response = $this->deleteJson('/api/watchlists/1');
        $response->assertUnauthorized();

        $response = $this->putJson('/api/watchlists');
        $response->assertMethodNotAllowed();

        $response = $this->deleteJson('/api/watchlists');
        $response->assertMethodNotAllowed();
    }

    public function test_watchlist_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/api/watchlists', ['name' => 'Test Watchlist']);

        $response->assertCreated()->assertJsonStructure(['id', 'name']);

        $this->assertDatabaseHas('watchlists', ['name' => 'Test Watchlist']);

        $response = $this->postJson('/api/watchlists');

        $response->assertUnprocessable()->assertJsonValidationErrorFor('name');
    }

    public function test_watchlist_index()
    {
        $users = User::factory()->count(3)->create();
        $this->actingAs($users[0]);
        $watchlists = Watchlist::factory()->count(5)->create(['user_id' => $users[0]->id]);

        $response = $this->getJson('/api/watchlists/');
        $response->assertOk()->assertJsonCount(5);
    }

    public function test_watchlist_show()
    {
        $users = User::factory()->count(3)->create();
        $this->actingAs($users[0]);
        $watchlists = Watchlist::factory()->count(2)->create(['user_id' => $users[0]->id]);

        $response = $this->getJson('/api/watchlists/'.$watchlists[0]->id);
        $response->assertOk()->assertJsonFragment(['id' => $watchlists[0]->id]);
    }

    public function test_watchlist_update()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $watchlist = Watchlist::factory()->create(['user_id' => $user->id]);

        $response = $this->putJson('/api/watchlists/'.$watchlist->id, ['name' => 'Test Watchlist 2']);
        $response->assertOk()->assertJsonStructure(['id', 'name']);
        $this->assertDatabaseHas('watchlists', ['id' => $watchlist->id, 'name' => 'Test Watchlist 2']);

        $response = $this->putJson('/api/watchlists/'.$watchlist->id,);
        $response->assertUnprocessable()->assertJsonValidationErrorFor('name');
    }

    public function test_watchlist_delete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $watchlist = Watchlist::factory()->create(['user_id' => $user->id]);

        $response = $this->deleteJson('/api/watchlists/'.$watchlist->id);
        $response->assertNoContent();
        
        $this->assertDatabaseMissing('watchlists', ['id' => $watchlist->id]);

        $response = $this->deleteJson('/api/watchlists/'.$watchlist->id);
        $response->assertNotFound();
    }
}
