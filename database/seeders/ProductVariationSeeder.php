<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Variation;

class ProductVariationSeeder extends Seeder
{
    public function run()
    {
        // Örnek bir ürün oluştur
        $product = Product::create([
            'title' => 'Nike Ayakkabı',
            'slug' => 'nike-ayakkabi',
            'description' => 'Bu ürün, Nike markasına ait bir ayakkabıdır.',
            'price' => 199,
            'live_at' => now()
        ]);

        // Ürünün farklı varyasyonlarını oluştur
        $variations = [
            ['title' => 'Kırmızı', 'type' => 'color', 'price' => 219, 'sku' => 'NIKE-01'],
            ['title' => 'Mavi', 'type' => 'color', 'price' => 219, 'sku' => 'NIKE-02'],
            ['title' => 'Siyah', 'type' => 'color', 'price' => 219, 'sku' => 'NIKE-03'],
            ['title' => '38', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-04'],
            ['title' => '39', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-05'],
            ['title' => '40', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-06'],
            ['title' => '41', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-07'],
            ['title' => '42', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-08'],
            ['title' => '43', 'type' => 'size', 'price' => 199, 'sku' => 'NIKE-09'],
        ];

        foreach ($variations as $index => $variationData) {
            // Varyasyonları oluştur
            $variation = new Variation($variationData);
            $variation->order = $index + 1;
            $variation->product()->associate($product);
            $variation->save();
        }
    }
}

