<?php

namespace App\Models;

use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    public function variation()
    {
        return $this->belongsTo(Variation::class);
    }
}
