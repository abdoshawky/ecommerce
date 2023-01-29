<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['item_id', 'customer_id', 'quantity'];

    protected $casts = ['quantity' => 'integer'];

    protected $with = ['item'];

    public function price(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->item->price * $this->quantity
        );
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
