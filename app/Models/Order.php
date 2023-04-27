<?php

namespace App\Models;

use App\Models\ShippingAddress;
use App\Models\ShippingType;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $fillable = [
        'email',
        'subtotal',
        'placed_at',
        'packaged_at',
        'shipped_at'
    ];

    public $timestamps = [
        'placed_at',
        'packaged_at',
        'shipped_at'
    ];
    
    public function shippingType()
    {
        return $this->belongsTo(ShippingType::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(shippingAddress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variations()
    {
        return $this->belongsToMany(Variation::class)
            ->withPivot(['quantity'])
            ->withTimestamps();
    }


    public static function booted()
    {
        static::creating(function ( Order $order)
        {
            $order->placed_at = now();
            $order->uuid = (string) Str::uuid();
        });
    }

    protected $statusses = [
        'placed_at',
        'packaged_at',
        'shipped_at'
    ];

    public function status()
    {
        return collect($this->statusses)->last( fn ($status) => filled($this->{$status}) );
    }
}
