<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'starting_price',
        'current_price',
        'starts_at',
        'ends_at',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
    
}
