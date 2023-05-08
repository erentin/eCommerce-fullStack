<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductsController extends Controller
{
    public function index(Product $product)
    {
        $products = Product::all();

        return view("adminProducts.index",[
            'products' => $products,
        ]);
    }
}
