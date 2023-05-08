<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class AyakkabiSeeder extends Seeder
{
    public function run(Product $product)
    {
        $brands = ['Nike', 'Adidas'];
        $types = ['Koşu', 'Basketbol', 'Yürüyüş'];
        $colors = ['Siyah', 'Beyaz', 'Kırmızı', 'Mavi', 'Yeşil'];
        
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product;
            $product->title = $brands[rand(0, 1)] . ' ' . $types[rand(0, 2)] . ' Ayakkabı';
            $product->slug = Str::slug($product->title).rand(1, 99999);
            $product->description = 'Bu ürün, ' . $brands[rand(0, 1)] . ' markasına ait ' . $types[rand(0, 2)] . ' ayakkabısıdır.';
            $product->price = rand(100, 500);
            $product->live_at = now();
            $product->save();
        }
    }
}

