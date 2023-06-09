<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionAgency extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function auction_post()
    {
        return $this->belongsTo(AuctionPost::class);
    }

    public function auction()
    {
        return $this->belongsTo(AuctionPost::class, 'auction_post_id');
    }
}
