<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function addStoreCredits(int $amount)
    {
        $this->store_credits += $amount;
        $this->save();
    }

    public function removeStoreCredits(int $amount)
    {
        $this->store_credits -= $amount;
        $this->save();
    }
}
