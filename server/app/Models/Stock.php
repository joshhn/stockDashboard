<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['symbol'];

    public function watchlists()
    {
        return $this->belongsToMany(Watchlist::class, 'watchlist_stock');
    }
}
