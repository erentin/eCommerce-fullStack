<?php

namespace App\Models;

use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Variation extends Model implements HasMedia
{
    use HasFactory;
    use HasRecursiveRelationships;
    use InteractsWithMedia;

    protected $fillable = ['product_id','title','price','type','sku','parent_id','order','live_at'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function inStock()
    {
        return $this->stockCount() > 0;
    }

    public function outOfStock()
    {
        return !$this->inStock();
    }

    public function lowStock()
    {
        return !$this->outOfStock() && $this->stockCount()<5;
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function stockCount()
    {
        return $this->descendantsAndSelf->sum(fn ($variation) => $variation->stocks->sum('amount'));
    }

    public function formattedPrice()
    {
        return Money::TRY($this->price,true);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb200x200')
            ->fit(Manipulations::FIT_CROP, 200, 200);
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->useFallbackUrl(url('/storage/no-image.png'));
    }
}
